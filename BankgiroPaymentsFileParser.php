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
						$this->_bgp->parsePost( $line );
					break;

					// Opening post
					case '05':
						if ( 	strcmp($this->_state, self::STATE_START_POST_PARSED) ||
								strcmp($this->_state, self::STATE_SUMMATION_POST_PARSED) )
						{
							$this->_state = self::STATE_OPENING_POST_PARSED;
							$this->_bgp->parsePost($line);
							//$this->parseOpeningPost($this->_bgp, $lineData);
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
							$this->_bgp->parsePost($line);
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
							$this->_bgp->parsePost($line);
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
							$this->_bgp->parsePost($line);
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

}
