<?php
/**
* @copyright	Copyright © 2012 Daniel Josefsson. All rights reserved.
* @license		GPL v3
* @example 		$payments = new BankgiroPayments( array("/path/to/filename") );
* 				echo "<pre>";
*					var_dump($payments);
*				echo "</pre>";
*/

/**
 * BankgiroPayments
 *
 * A class made for parse Bankgiro Inbetalningar files.
 *
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @version     v0.2
 */
class BankgiroPayments
{
	// File info
	protected $_filename;
	protected $_fileData;

	// Return options
	protected $_stripLeadingZeros;

	// Start post content (01)
	protected $_layout;
	protected $_version;
	protected $_timestamp;
	protected $_fileMarker;

	// End post
	protected $_nrPaymentPosts;
	protected $_nrDeductionPosts;
	protected $_nrExternalReferencePosts;
	protected $_nrDepositPosts;

	// State machine
	protected $_state;
	protected $_error;
	const STATE_IDLE	= 'Idle';
	const STATE_ERROR	= 'Error occured';
	const STATE_PARSING	= 'Parsing file';
	const STATE_START_POST_PARSED = 'Start post parsed';
	const STATE_END_POST_PARSED = 'END post parsed';
	const STATE_OPENING_POST_PARSED = 'Opening post parsed';
	const STATE_SUMMATION_POST_PARSED = 'Summation post parsed';
	const STATE_DONE	= 'Done';

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
	 * @autor	Daniel Josefsson <dannejosefsson@gmail.com>
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
	 * @autor	Daniel Josefsson <dannejosefsson@gmail.com>
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
	 * @autor	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @since	v0.2
	 * @return	string $_state
	 */
	public function getState()
	{
		return $this->_state;
	}

	/**
	 * Returns found errors.
	 * @autor	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @since	v0.2
	 */
	public function getErrors()
	{
		return $this->_error;
	}

	/**
	* Reads and stores earlier given file.
	* @autor	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @return BankgiroPayments
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
			$this->_state = self::STATE_ERROR;
			$this->_error[] = "Failed to read $this->getFilename()";
		}
		return $this;
	}

	/**
	 * Parses given file.
	 * @autor	Daniel Josefsson <dannejosefsson@gmail.com>
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
			// Openingpost
			$bankgiroAccount;
			$plusgiroAccount;
			$currency;
			foreach ($this->_fileData as $line)
			{
				$lineType = substr($line, 0, 2);
				$lineData = substr($line, 2);
				switch ($lineType) {
					// Start post
					case '01':
						$this->_state = self::STATE_START_POST_PARSED;
						$this->parseStartPost( $lineData );
						break;

					//Opening post
					case '05':
						if ( 	strcmp($this->_state, self::STATE_START_POST_PARSED) ||
								strcmp($this->_state, self::STATE_SUMMATION_POST_PARSED) )
						{
							$this->_state = self::STATE_OPENING_POST_PARSED;
							$this->parseOpeningPost($lineData, $bankgiroAccount, $plusgiroAccount, $currency, $this->_stripLeadingZeros);

							echo "<pre>";
							var_dump($bankgiroAccount, $plusgiroAccount, $currency);
							echo "</pre>";
						}
						else
						{
							$this->_state = self::STATE_ERROR;
							$this->_error[] = 'Start post or payment summation post was not parsed before next opening post.';
						}
						break;

					// End post
					case '70':
						if ( 	strcmp($this->_state, self::STATE_START_POST_PARSED) ||
								strcmp($this->_state, self::STATE_SUMMATION_POST_PARSED) )
						{
							$this->_state = self::STATE_END_POST_PARSED;
							$this->parseEndPost($lineData);
						}
						else
						{
							$this->_state = self::STATE_ERROR;
							$this->_error[] = 'Start post or payment summation post was not parsed before end post.';
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
	 * @autor	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @since	v0.2
	 * @param unknown_type $lineData
	 */
	private function parseStartPost( $lineData )
	{
		$this->_layout 		= trim(substr($lineData, 0, 20));
		$this->_version		= (int) substr($lineData, 20, 2);
		$this->_timestamp	= date('Y-m-d H:i:s', strtotime(substr($lineData, 22, 8).'T'. substr($lineData, 30, 6)));
		// Microseconds (lineData[36-41]) are not used.
		$this->_fileMarker	= substr($lineData, 42, 1);
		// Reserved placeholders (lineData[43-77]) are not used.
	}

	/**
	 * Parses end post (70).
	 * @autor	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @since	v0.2
	 * @param string $lineData
	 */
	private function parseEndPost( $lineData )
	{
		// Check so that the count of payment posts is consistent.
		if ( ((int) substr($lineData, 0, 8) - $this->_nrPaymentPosts) )
		{
			$this->_state = self::STATE_ERROR;
			$error = "The payment posts count is not consistent. ";
			$error .= "Given in file: ".(int) substr($lineData, 0, 8)." Parsed: ".$this->_nrPaymentPosts;
			$this->_error[] = $error;
		}
		// Check so that the count of deduction posts is consistent
		if ( ((int) substr($lineData, 8, 8) - $this->_nrDeductionPosts) )
		{
			$this->_state = self::STATE_ERROR;
			$error = "The deduction posts count is not consistent. ";
			$error .= "Given in file: ".(int) substr($lineData, 8, 8)." Parsed: ".$this->_nrDeductionPosts;
			$this->_error[] = $error;
		}
		// Check so that the count of external reference posts is consistent
		if ( ((int) substr($lineData, 16, 8) - $this->_nrExternalReferencePosts) )
		{
			$this->_state = self::STATE_ERROR;
			$error = "The external references posts count is not consistent. ";
			$error .= "Given in file: ".(int) substr($lineData, 16, 8)." Parsed: ".$this->_nrExternalReferencePosts;
			$this->_error[] = $error;
		}
		// Check so that the count of external reference posts is consistent
		if ( ((int) substr($lineData, 24, 8) - $this->_nrDepositPosts) )
		{
			$this->_state = self::STATE_ERROR;
			$error = "The deposit posts count is not consistent. ";
			$error .= "Given in file: ".(int) substr($lineData, 24, 8)." Parsed: ".$this->_nrDepositPosts;
			$this->_error[] = $error;
		}
		// Reserved placeholders (lineData[32-77]) are not used.
	}

	/**
	 * Parses opening post (05).
	 * @autor	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @since	v0.2
	 * @param string $lineData
	 * @param string $bankgiroAccount
	 * @param string $plusgiroAccount
	 * @param string $currency
	 * @param bool	 $stripLeadingZeros
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
