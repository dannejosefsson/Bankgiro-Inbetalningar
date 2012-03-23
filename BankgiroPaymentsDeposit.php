<?php

/**
* BankgiroPaymentDeposit
*
* A class made to contain a deposit parsed from Bankgiro Inbetalningar files.
*
* @copyright	Copyright © 2012 Daniel Josefsson. All rights reserved.
* @license		GPL v3
* @author		Daniel Josefsson <dannejosefsson@gmail.com>
* @version		v0.1
*/
class BankgiroPaymentsDeposit
{
	/**
	* Bankgiro account number.
	* Max length: 10
	* Can be zero padded.
	* @var int
	*/
	protected	$_bankgiroAccountNumber;
	/**
	* Plusgiro account number.
	* Max length: 10
	* Can be zero padded.
	* @var string
	*/
	protected	$_plusgiroAccountNumber;
	/**
	* Bank account number.
	* Divided into clearing number and account number.
	* Max length clearing number: 4
	* Max length account number: 12
	* Can be zero padded.
	* @var array
	*/
	protected	$_bankAccountNumber;
	/**
	* Currency.
	* Possible values: "SEK", "EUR".
	* @var string
	*/
	protected	$_currency;
	/**
	* Deposit number.
	* Unique per bankgiro account number and year.
	* Max length: 5
	* Can be zero padded.
	* @var int
	 */
	protected	$_depositNumber;
	/**
	* Payment date.
	* YYYYMMDD
	* @var string
	*/
	protected	$_paymentDate;
	/**
	* Payment value.
	* Max length: 18
	* Can be zero padded.
	* @var int
	*/
	protected	$_paymentValue;
	/**
	* Payment count.
	* Is the sum of deposits and deductions.
	* Max length: 8.
	* @var int
	 */
	protected	$_paymentCount;
	/**
	* Type of payment.
	* Possible values "K", "D", "S".
	* @var unknown_type
	 */
	protected	$_paymentType;

	/**
	* Returns Bankgiro account number.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	 */
	public function getBankgiroAccountNumber()
	{
		return $this->_bankgiroAccountNumber;
	}

	/**
	* Returns Plusgiro account number.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	*/
	public function getPlusgiroAccountNumber()
	{
		return $this->_plusgiroAccountNumber;
	}

	/**
	* Returns bank account number.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	*/
	public function getBankAccountNumber()
	{
		return $this->_bankAccountNumber;
	}

	/**
	* Sets new Bankgiro account number.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	* @param 	int $bankgiroAccountNumber
	* @return	BankgiroPaymentDeposit
	 */
	public function setBankgiroAccountNumber( $bankgiroAccountNumber )
	{
		$this->_bankgiroAccountNumber = $bankgiroAccountNumber;
		return $this;
	}

	/**
	* Sets new Plusgiro account number.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	* @param 	string $plusgiroAccountNumber
	* @return	BankgiroPaymentDeposit
	*/
	public function setPlusgiroAccountNumber( $plusgiroAccountNumber )
	{
		$this->_plusgiroAccountNumber = $plusgiroAccountNumber;
		return $this;
	}

	/**
	* Sets new bank account number.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	* @param 	int $bankgiroAccountNumber
	* @return	BankgiroPaymentDeposit
	*/
	public function setBankAccountNumber( $bankAccountNumber )
	{
	$this->_bankAccountNumber = $bankAccountNumber;
	return $this;
	}

	/**
	* Returns currency.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	*/
	public function getCurrency()
	{
		return $this->_currency;
	}

	/**
	* Returns deposit number.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	*/
	public function getDepositNumber()
	{
		return $this->_DepositNumber;
	}

	/**
	* Sets new currency.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	* @param 	int $currency
	* @return	BankgiroPaymentDeposit
	*/
	public function setCurrency( $currency )
	{
		$this->_currency = $currency;
		return $this;
	}

	/**
	* Sets new deposit number.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	* @param 	int $depositNumber
	* @return	BankgiroPaymentDeposit
	*/
	public function setDepositNumber( $depositNumber )
	{
		$this->_depositNumber = $depositNumber;
		return $this;
	}

	/**
	* Returns payment date.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	*/
	public function getPaymentDate()
	{
		return $this->_paymentDate;
	}

	/**
	* Returns payment value.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	*/
	public function getPaymentValue()
	{
		return $this->_paymentValue;
	}

	/**
	* Returns payment count.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	*/
	public function getPaymentCount()
	{
		return $this->_paymentCount;
	}

	/**
	* Returns payment type.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	*/
	public function getPaymentType()
	{
		return $this->_paymentType;
	}

	/**
	* Sets new payment date.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	* @param 	int $paymentDate
	* @return	BankgiroPaymentDeposit
	*/
	public function setPaymentDate( $paymentDate )
	{
	$this->_paymentDate = $paymentDate;
	return $this;
	}

	/**
	* Sets new payment value.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	* @param 	int $paymentValue
	* @return	BankgiroPaymentDeposit
	*/
	public function setPaymentValue( $paymentValue )
	{
	$this->_paymentValue = $paymentValue;
	return $this;
	}

	/**
	* Sets new payment count.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	* @param 	int $paymentCount
	* @return	BankgiroPaymentDeposit
	*/
	public function setPaymentCount( $paymentCount )
	{
	$this->_paymentCount = $paymentCount;
	return $this;
	}

	/**
	* Sets new payment type.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.1
	* @param 	int $paymentType
	* @return	BankgiroPaymentDeposit
	*/
	public function setPaymentType( $paymentType )
	{
	$this->_paymentType = $paymentType;
	return $this;
	}

}
