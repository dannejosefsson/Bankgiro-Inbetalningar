<?php
require_once './BankgiroPaymentsDeposit.php';

/**
* BankgiroPayments
*
* A class made for hold Bankgiro Inbetalningar structs.
*
* @author		Daniel Josefsson <dannejosefsson@gmail.com>
* @copyright	Copyright © 2012 Daniel Josefsson. All rights reserved.
* @license		GPL v3
* @version		v0.3
* @uses			BankgiroPaymentDeposit
*/
class BankgiroPayments
{
	/**
	* Layout type
	* Max length: 20
	* @var string
	*/
	protected $_layout;
	/**
	* Version
	* Max length: 2
	* @var int
	*/
	protected $_version;
	/**
	* Timestamp
	* @var MySQL timestamp
	*/
	protected $_timestamp;
	/**
	* Microseconds
	* Length: 6
	* @var string
	*/
	protected $_microSeconds;
	/**
	* Test marker
	* Length: 1
	* @var string
	*/
	protected $_testMarker;

	/**
	* Deposit posts count.
	* Max length: 8
	* @var array BankgiroPaymentsDeposit
	*/
	protected $_deposits;

	/**
	* Array storing errors
	* @var array of strings
	*/
	protected	$_errors;

	// File info
	protected $_filename;
	protected $_fileData;


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
	*
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
		}
		elseif ( is_string( $options ) )
		{
			$this->setFilename($options);
		}
		$this->clearDeposits();
		$this->_errors = array();
		$this->_fileData	= array();
		$this->_error		= array();
	}

	/**
	* Returns layout
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	* $return	int $_layout
	*/
	public function getLayout()
	{
		return $this->_layout;
	}

	/**
	* Sets layout
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	* @param	string $layout
	* @return	BankgiroPayments
	*/
	public function setLayout( $layout )
	{
		$this->_layout = $layout;
		return $this;
	}

	/**
	* Returns version
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	*/
	public function getVersion()
	{
		return $this->_version;
	}

	/**
	* Sets version.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	* @param	int $version
	* @return	BankgiroPayments
	*/
	public function setVersion( $version )
	{
		$this->_version = $version;
		return $this;
	}

	/**
	* Returns timestamp
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	*/
	public function getTimestamp()
	{
		return $this->_timestamp;
	}

	/**
	* Sets timestamp.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	* @param	MySQL_timestamp $timestamp
	* @return	BankgiroPayments
	*/
	public function setTimestamp( $timestamp )
	{
		$this->_timestamp = $timestamp;
		return $this;
	}

	/**
	* Returns micro seconds
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	*/
	public function getMicroSeconds()
	{
		return $this->_microSeconds;
	}

	/**
	* Sets micro seconds.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	* @param	int $microSeconds
	* @return	BankgiroPayments
	*/
	public function setMicroSeconds( $microSeconds )
	{
		$this->_microSeconds = $microSeconds;
		return $this;
	}

	/**
	* Returns test marker.
	* testMarker will be "T" if it is test or "P" if it is
	* production.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	*/
	public function getTestMarker()
	{
		return $this->_testMarker;
	}

	/**
	* Sets test marker.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	* @param	int $testMarker
	* @return	BankgiroPayments
	*/
	public function setTestMarker( $testMarker )
	{
		$this->_testMarker = $testMarker;
		return $this;
	}

	/**
	* Get filename
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.3
	*/
	public function getFilename()
	{
		return $this->_filename;
	}

	/**
	 * Sets a new filename. Returns STATE_ERROR on failure.
	 * @since	v0.3
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
	* Returns errors.
	* @author	Daniel Josefsson
	* @since	v0.2
	* @return	array of strings
	*/
	public function getErrors()
	{
		return $this->_errors;
	}

	/**
	 * Sets new error.
	 * @author	Daniel Josefsson
	 * @since	v0.2
	 * @param	string $errors
	 * @return	BankgiroPaymentsDeposit
	 */
	public function setError( $error )
	{
		$this->_errors[] = $error;
		return $this;
	}

	/**
	* Returns deposit objects count.
	*
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	* @return	int $depositsCount
	*/
	public function getDepositsCount()
	{
		return sizeof($this->_deposits);
	}

	/**
	* Returns posts counts.
	* @todo		make body
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	* @todo		build functions for external references.
	 */
	public function getPostsCounts()
	{
		$paymentPosts = 0;
		$deductionPosts = 0;
		$extraReferences = 0;
		foreach ($this->_deposits as $deposit)
		{
			$paymentPosts += $deposit->getPaymentCount();
			$deductionPosts += $deposit->getDeductionCount();
			$extraReferences+= $deposit->getExtraReferencesCount();
		}
		$postsCounts = array(	$paymentPosts,
								$deductionPosts,
								$extraReferences,
								$this->getDepositsCount(), //Deposit counts
								);
		return $postsCounts;
	}

	/**
	* Clear deposits.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @return	BankgiroPayments
	*/
	public function clearDeposits()
	{
		unset($this->_deposits);
		$this->_deposits = array();
		return $this;
	}

	/**
	* Add new BankgiroPaymentsDeposit to container.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @return	int BankgiroPayments
	*/
	public function addDeposit()
	{
		$this->_deposits[] = new BankgiroPaymentsDeposit();
		return $this;
	}

	/**
	* Return index to the latest inserted deposit.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @return	int $keyToDeposit
	*/
	public function lastDepositIndex()
	{
		end($this->_deposits);
		return key($this->_deposits);
	}

	/**
	* Returns wanted deposit
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @param 	int $index
	* @return	BankgiroPaymentsDeposit
	 */
	public function getDeposit( $index )
	{
		return $this->_deposits[$index];
	}

	/**
	* Parses line,given with the syntax of posts 1 and 70 in Bankgiro Inbetalningar.
	* Transfers lines with post type 5, 15, 20-29 to BankgiroPaymentsDeposit objects for
	* parsing.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @param	string $line
	* @return	boolean
	*/
	public function parsePost( $line )
	{
		$return = false;
		$postType = substr($line, 0, 2);
		$postData = substr($line, 2, 78);
		switch ($postType)
		{
			case '01':
				$return = $this->parseStartPost($postData);
				break;
			case '05':
				$depositIndex = $this->addDeposit()->lastDepositIndex();
				$return = $this->getDeposit($depositIndex)->parsePost($line);
				break;
			case '15':
				$depositIndex = $this->lastDepositIndex();
				$return = $this->getDeposit($depositIndex)->parsePost($line);
				break;
			case '70':
				$return = $this->parseEndPost($postData);
			default:
				$depositIndex = $this->lastDepositIndex();
				$return = $this->getDeposit($depositIndex)->parsePost($line);
				break;
		}
		return $return;
	}

	/**
	* Parses start post (01).
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @param 	string				$lineData
	* @return	bool
	*/
	private function parseStartPost( $lineData )
	{
		$this->setLayout(trim(substr($lineData, 0, 20)));
		$this->setVersion((int) substr($lineData, 20, 2));
		$this->setTimestamp(date(	'Y-m-d H:i:s',
									strtotime(substr($lineData, 22, 8).'T'. substr($lineData, 30, 6))));
		$this->setMicroSeconds(substr($lineData, 36, 6));
		$this->setTestMarker(substr($lineData, 42, 1));
		// Reserved placeholders (lineData[43-77]) are not used.
		return $this;
	}

	/**
	* Parses end post (70).
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @param 	string 				$lineData
	* @return	bool
	*/
	private function parseEndPost( $lineData )
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
		$parsedCounts = $this->getPostsCounts();
		$return = true;
		for ($i = 0; $i < sizeof($parsedCounts); $i++)
		{
			if ( !$this->checkConsistancy(	$parsedCounts[$i],
											$postsCounts[$i],
											$errorMessages[$i] ) )
			{
				$return = false;
			}
		}
		// Reserved placeholders (lineData[32-77]) are not used.
		return $return;
	}

	/**
	* Reads and stores earlier given file. Sets state to error on failure.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.3
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
		$return = false;

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
				$postType = substr($line, 0, 2);
				$postData = substr($line, 2, 78);
				switch ($postType)
				{
					// Start post
					case '01':
						$this->_state = self::STATE_START_POST_PARSED;
						$return = $this->parseStartPost($postData);
						break;

						// Opening post
					case '05':
						if ( 	strcmp($this->_state, self::STATE_START_POST_PARSED) ||
								strcmp($this->_state, self::STATE_SUMMATION_POST_PARSED) )
						{
							$this->_state = self::STATE_OPENING_POST_PARSED;
							$depositIndex = $this->addDeposit()->lastDepositIndex();
							$return = $this->getDeposit($depositIndex)->parsePost($line);
						}
						else
						{
							$this->setError('Start post or summation post was not parsed before next opening post.');
						}
						break;

						// Payment post
					case '20':
					case '21':
					case '22':
					case '23':
					case '25':
					case '26':
					case '27':
					case '28':
					case '29':
						if ( 	strcmp($this->_state, self::STATE_START_POST_PARSED) ||
								strcmp($this->_state, self::STATE_PAYMENT_POST_PARSED) )
						{
							$this->_state = self::STATE_PAYMENT_POST_PARSED;
							$depositIndex = $this->lastDepositIndex();
							$return = $this->getDeposit($depositIndex)->parsePost($line);
						}
						else
						{
							$this->setError('Start post or payment post was not parsed before payment post.');
						}
						break;

					case '15':
						if ( 	strcmp($this->_state, self::STATE_OPENING_POST_PARSED) ||
						strcmp($this->_state, self::STATE_PAYMENT_POST_PARSED) ||
						strcmp($this->_state, self::STATE_DEDUCTION_POST_PARSED)	)
						{
							$this->_state = self::STATE_SUMMATION_POST_PARSED;
							$depositIndex = $this->lastDepositIndex();
							$return = $this->getDeposit($depositIndex)->parsePost($line);
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
							$return = $this->parseEndPost($postData);
						}
						else
						{
							$this->setError('Start post or summation post was not parsed before end post.');
						}
						break;

					default:
						$this->setError("Line error: $line");
						break;
				}
			}
		}
		return $this;
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
