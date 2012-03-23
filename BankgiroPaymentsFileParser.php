<?php
require_once './BankgiroPayments.php';

/**
* BankgiroPaymentsFileParser
*
* A class made for parse Bankgiro Inbetalningar files.
*
* @author		Daniel Josefsson <dannejosefsson@gmail.com>
* @copyright	Copyright © 2012 Daniel Josefsson. All rights reserved.
* @license		GPL v3
* @version    	v0.4
* @uses			BankgiroPayments
*/
class BankgiroPaymentsFileParser
{
	// File info
	protected $_filename;
	protected $_fileData;

	// Return options
	protected $_stripLeadingZeros;

	protected $_bgp;

	// State machine
	protected $_state;
	protected $_error;
	const STATE_IDLE					= 'Idle';
	const STATE_ERROR					= 'Error occured';
	const STATE_PARSING					= 'Parsing file';
	const STATE_START_POST_PARSED		= 'Start post parsed';
	const STATE_END_POST_PARSED			= 'End post parsed';
	const STATE_OPENING_POST_PARSED		= 'Opening post parsed';
	const STATE_SUMMATION_POST_PARSED	= 'Summation post parsed';
	const STATE_PAYMENT_POST_PARSED		= 'Payment post parsed';
	const STATE_DEDUCTION_POST_PARSED	= 'Deduction post parsed';
	const STATE_FILE_COMPLETLY_PARSED	= 'File completly parsed';

	/**
	* The option parameter consists of string or an array
	* containing filename.
	* The option parameter is not mandatory.
	*
	* @since	v0.1
	* @param	array/string $options
	*/
	public function __construct( $options = null )
	{
		$this->_state = self::STATE_IDLE;
		if ( is_array($options) )
		{
			$i = 0;
			$this->setFilename($options[$i++]);
			if ( isset($options[$i]) )
			{
				(is_bool($options[$i])) ? $this->_stripLeadingZeros = $options[$i] : $this->_stripLeadingZeros = false;
				$i++;
			}
			else
			{
				$this->_stripLeadingZeros = false;
			}
		}
		elseif ( is_string( $options ) )
		{
			$this->setFilename($options);
			$this->_stripLeadingZeros = false;
		}
			$this->_fileData	= array();
			$this->_error		= array();

			// Initate end post
			$this->_nrPaymentPosts = $this->_nrDeductionPosts = 0;
			$this->_nrExternalReferencePosts = $this->_nrDepositPosts = 0;
	}

	/**
	* Get filename
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	*/
	public function getFilename()
	{
		return $this->_filename;
	}

	/**
	* Sets a new filename. Returns STATE_ERROR on failure.
	* @since	v0.1
	*
	* @param 	$newFilename	- path and filename.
	* @param	$error			- returns error if $newFilename is not found.
	* @return	BankgiroPayments
	*/
	public function setFilename( $newFilename )
	{
		if ( isset($newFilename) && "" != $newFilename )
		{
			if ( file_exists($newFilename) )
			{
				$this->_filename = $newFilename;
			}
			else
			{
				$this->_state = self::STATE_ERROR;
				$error[] = "$newFilename is not a file.";
			}
		}
		return $this;
	}

	 /**
	 * Get fileData
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @since	v0.2
	 * @return	array $this->_fileData
	 */
	 public function getFileData()
	 {
			return $this->_fileData;
	}

	/**
	* Sets _fileData.
	* @since 	v0.1
	 *
	 * @param 	array $newFileData
	 * @return	BankgiroPayments
	 */
	 private function setFileData( $newFileData )
	 {
		$this->_fileData = $newFileData;
		return $this;
	}

	/**
	* Returns current state
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @return	string $_state
	*/
	public function getState()
	{
		return $this->_state;
	}

	/**
	* Returns found errors.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	*/
	public function getErrors()
	{
		return $this->_error;
	}

	/**
	 * Sets new error with given error message. Also sets
	 * the state machine to STATE_ERROR.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.3
	* @param unknown_type $errorMessage
	 */
	public function setError( $errorMessage )
	{
		$this->_error[] = $errorMessage;
		$this->_state = self::STATE_ERROR;
	}

	/**
	* Returns the parsed BankgiroPayments
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.4
	* @return	BankgiroPayments
	 */
	public function getBankgiroPayments()
	{
		return $this->_bgp;
	}

	/**
	* Reads and stores earlier given file.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @return 	BankgiroPayments
	*/
	public function readFile()
	{
		// Clear array to make sure that not old data is parsed again.
		$this->_fileData=array();
		if ($openFile = file($this->getFilename()))
		{
			foreach ($openFile as $lineNum => $line)
			{
				$this->_fileData[$lineNum] = $line;
			}
		}
		else
		{
			$this->setError("Failed to read $this->getFilename()");
		}
		return $this;
	}

	/**
	* Parses given file.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @param 	string $filename
	* @return	BankgiroPayments
	*/
	public function parseFile( $filename = null )
	{
		$this->setFilename($filename);

		// Read file if setFilename succeded.
		if ( strcmp($this->_state, self::STATE_ERROR) )
		{
			$this->_state = self::STATE_PARSING;
			$this->readFile();
		}

		// Parse if readFile succeded.
		if ( strcmp($this->_state, self::STATE_ERROR) )
		{
			foreach ($this->_fileData as $line)
			{
				$lineType = substr($line, 0, 2);
				$lineData = substr($line, 2);
				switch ($lineType)
				{
					// Start post
					case '01':
						$this->_state = self::STATE_START_POST_PARSED;
						$this->_bgp = new BankgiroPayments();
						$this->_bgp = $this->parseStartPost( $this->_bgp, $lineData );
					break;

					// Opening post
					case '05':
						if ( 	strcmp($this->_state, self::STATE_START_POST_PARSED) ||
								strcmp($this->_state, self::STATE_SUMMATION_POST_PARSED) )
						{
							$this->_state = self::STATE_OPENING_POST_PARSED;
							$this->parseOpeningPost($this->_bgp, $lineData);
						}
						else
						{
							$this->setError('Start post or summation post was not parsed before next opening post.');
						}
					break;

					case '15':
						if ( 	strcmp($this->_state, self::STATE_OPENING_POST_PARSED) ||
								strcmp($this->_state, self::STATE_PAYMENT_POST_PARSED) ||
								strcmp($this->_state, self::STATE_DEDUCTION_POST_PARSED)	)
						{
							$this->_state = self::STATE_SUMMATION_POST_PARSED;
							$this->parseSummationPost($this->_bgp, $lineData);
						}
						else
						{
							$this->setError('Opening post or payment summation post was not parsed before next opening post.');
						}
					break;

					// End post
					case '70':
						if ( 	strcmp($this->_state, self::STATE_START_POST_PARSED) ||
								strcmp($this->_state, self::STATE_SUMMATION_POST_PARSED) )
						{
							$this->_state = self::STATE_END_POST_PARSED;
							$this->parseEndPost($this->_bgp, $lineData);
						}
						else
						{
							$this->setError('Start post or summation post was not parsed before end post.');
						}
					break;

					default:
						;
					break;
				}
			}
		}
		return $this;
	}

	/**
	* Parses start post (01).
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @param	BankgiroPayments	$bgp
	* @param 	string				$lineData
	* @return	BankgiroPayments
	*/
	private function parseStartPost( BankgiroPayments $bgp, $lineData )
	{
		$bgp->setLayout(trim(substr($lineData, 0, 20)));
		$bgp->setVersion((int) substr($lineData, 20, 2));
		$bgp->setTimestamp(date(	'Y-m-d H:i:s',
				strtotime(substr($lineData, 22, 8).'T'. substr($lineData, 30, 6))));
		$bgp->setMicroSeconds(substr($lineData, 36, 6));
		$bgp->setTestMarker(substr($lineData, 42, 1));
		// Reserved placeholders (lineData[43-77]) are not used.
		return $bgp;
	}

	/**
	* Parses end post (70).
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @param	BankgiroPayments 	$bgp
	* @param 	string 				$lineData
	* @return	BankgiroPayments
	*/
	private function parseEndPost( BankgiroPayments $bgp, $lineData )
	{
		// Check so that the count of payment posts is consistent.
		$postsCounts = array(	// Payment posts count.
								(int) substr($lineData, 0, 8),
								// Deduction posts count.
								(int) substr($lineData, 8, 8),
								// External references posts count.
								(int) substr($lineData, 16, 8),
								// Deposit posts count.
								(int) substr($lineData, 24, 8),
							);
		$errorMessages = array(
								"payment posts count",
								"deduction posts count",
								"external references posts count",
								"deposit posts count",
							);
		$parsedCounts = $bgp->getPostsCounts();

		for ($i = 0; $i < sizeof($parsedCounts); $i++)
		{
			$this->checkConsistancy($parsedCounts[$i], $postsCounts[$i], $errorMessages[$i] );
		}
		// Reserved placeholders (lineData[32-77]) are not used.
		return $bgp;
	}

	/**
	* Parses opening post (05).
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @param	BankgiroPayments 	$bgp
	* @param 	string				$lineData
	* @return	BankgiroPayments
	*/
	private function parseOpeningPost( BankgiroPayments $bgp, $lineData )
	{
		$depositIndex = $this->_bgp->addDeposit()->lastDepositIndex();

		$bgp->getDeposit($depositIndex)->setBankgiroAccountNumber(
													(int) substr($lineData, 0, 10));
		if ( $this->_stripLeadingZeros )
		{
			$bgp->getDeposit($depositIndex)->setPlusgiroAccountNumber(
											ltrim(substr($lineData, 10, 10), "0 "));
		}
		else
		{
			$bgp->getDeposit($depositIndex)->setPlusgiroAccountNumber(
											substr($lineData, 10, 10));
		}
		$bgp->getDeposit($depositIndex)->setCurrency(substr($lineData, 20, 3));
		// Reserved placeholders (lineData[23-77]) are not used.
		return $bgp;
	}

	/**
	* Parses summation post (15).
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @param 	BankgiroPayments	$bgp
	* @param 	string				$lineData
	* @return	BankgiroPayments
	 */
	private function parseSummationPost( BankgiroPayments $bgp, $lineData )
	{
		$depositIndex = $this->_bgp->lastDepositIndex();

		$bgp->getDeposit($depositIndex)->setBankAccountNumber(
											(int) substr($lineData, 0, 35));
		$bgp->getDeposit($depositIndex)->setPaymentDate(substr($lineData, 35, 8));
		$bgp->getDeposit($depositIndex)->setDepositNumber(
											(int) substr($lineData, 43, 5));

		$this->checkConsistancy($bgp->getDeposit($depositIndex)->getPaymentValue(),
								(int) substr($lineData, 48, 18),
								"payment value");

		$this->checkConsistancy($bgp->getDeposit($depositIndex)->getCurrency(),
								substr($lineData, 66, 3),
								"currency");

		$this->checkConsistancy($bgp->getDeposit($depositIndex)->getPaymentCount(),
								(int) substr($lineData, 69, 8),
								"payment count");
		$bgp->getDeposit($depositIndex)->setPaymentType(substr($lineData, 77, 1));
		echo "<pre>";
			var_dump($lineData);
		echo "</pre>";
		return $bgp;
	}

	/**
	* Check if the value of left and right are the same.
	* If not; trow an error with the dynamic variableName.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.4
	* @param 	mixed	$left
	* @param 	mixed	$right
	* @param 	string	$variableName
	* @return 	boolean
	 */
	private function checkConsistancy( $left, $right, $variableName )
	{
		if (is_int($left) && is_int($right) && !((int) $left - (int) $right))
		{
			return true;
		}
		elseif ( is_string($left) && is_string($right) && !strcmp($left, $right) )
		{
			return true;
		}
		else
		{
			$error = "Parsed and given $variableName are not consistent. ";
			$error .= "Parsed: ".$left." Given: ".$right;
			$this->setError($error);
			return false;
		}
	}
}
