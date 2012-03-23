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
* @version    	v0.3
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
			// Opening post
			/**
			* Max length: 10
			* Can be zero padded.
			*/
			$bankgiroAccount;
			/**
			* Max length: 10
			* Can be zero padded.
			*/
			$plusgiroAccount;
			/**
			* Length: 3
			*/
			$currency;

			// Summation post
			/**
			* Max length: 35
			* Can be zero padded.
			*/
			$bankAccount;
			/**
			* Length: 8
			* YYYYMMDD.
			*/
			$paymentDate;
			/**
			* Max length: 5
			 * Can be zero padded.
			 */
			 $depositNumber;
			 /**
			* Max length: 18
			* Can be zero padded.
			* Last two digits are ören.
			*/
			$paymentValue;
			/**
			* Max length: 8
			* Number of payment and deduction posts.
			*/
			$paymentCount;
			/**
			* Length: 1
			* Custumer specific. Can be "K", "D", "S" or " ".
			*/
			$paymentType;

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
							$this->parseOpeningPost($lineData, $bankgiroAccount, $plusgiroAccount, $currency, $this->_stripLeadingZeros);
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
							//$this->parseSummationPost();
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
	* @param	BankgiroPayments $bgp
	* @param 	string $lineData
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
								"The payment posts count is not consistent. ",
								"The deduction posts count is not consistent. ",
								"The external references posts count is not consistent. ",
								"The deposit posts count is not consistent. ",
							);
		$readCounts = $bgp->getPostsCounts();

		for ($i = 0; $i < sizeof($postsCounts); $i++)
		{
			if ( $postsCounts[$i] - $readCounts[$i] )
			{
				$error = $errorMessages[$i]."Parsed: ".$readCounts[$i];
				$error .= " Given: ".$postsCounts[$i];
				$this->setError($error);
			};
		}
		// Reserved placeholders (lineData[32-77]) are not used.
	}

	/**
	* Parses opening post (05).
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @param 	string	$lineData
	* @param 	string	$bankgiroAccount
	* @param 	string	$plusgiroAccount
	* @param 	string	$currency
	* @param 	bool	$stripLeadingZeros
	*/
	private function parseOpeningPost( $lineData, &$bankgiroAccount, &$plusgiroAccount, &$currency, $stripLeadingZeros = 1 )
	{
		if ( $stripLeadingZeros )
		{
			$bankgiroAccount = (string) ((int) substr($lineData, 0, 10));
			$plusgiroAccount = ltrim(substr($lineData, 10, 10), "0 ");
		}
		else
		{
			$bankgiroAccount = substr($lineData, 0, 10);
			$plusgiroAccount = substr($lineData, 10, 10);
		}
		$currency = substr($lineData, 20, 3);
		// Reserved placeholders (lineData[23-77]) are not used.
	}
}
