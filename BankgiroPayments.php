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
	* @todo		build functions for payments, deductions and external references.
	 */
	public function getPostsCounts()
	{
		$postsCounts = array(	0,
								0,
								0,
								$this->getDepositsCount(),
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
}
