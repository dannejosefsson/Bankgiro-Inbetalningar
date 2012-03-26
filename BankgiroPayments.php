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
* @version		v0.2
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

	/**
	*
	*
	* @since	v0.1
	* @param	array/string $options
	*/
	public function __construct( $options = null )
	{
		if ( is_array($options) )
		{

		}
		elseif ( is_string( $options ) )
		{

		}
		$this->clearDeposits();
		$this->_errors = array();
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
