<?php

/**
* BankgiroPaymentTransaction
*
* A class made to contain a payment post parsed from Bankgiro Inbetalningar files.
*
* @copyright	Copyright © 2012 Daniel Josefsson. All rights reserved.
* @license		GPL v3
* @author		Daniel Josefsson <dannejosefsson@gmail.com>
* @version		v0.1
*/
abstract class BankgiroPaymentsTransaction
{
	/**
	* Transaction code.
	* Possible values "20", "21", "22", "23".
	* Max length: 2
	* @var int
	*/
	protected	$_transactionCode;
	/**
	* Sender Bankgiro account number.
	* Max length: 10
	* @var int
	*/
	protected	$_senderBankgiroAccountNumber;
	/**
	* Amount.
	* Last two digits are ören.
	* Max length 18
	* @var int
	 */
	protected	$_amount;
	/**
	* Reference
	* Can be both int or string. Depends on $_referenceCode.
	* Max length: 25
	* @var mixed
	*/
	protected	$_reference;
	/**
	* Reference code
	* Length: 1
	* Tells what kind of reference $_reference is.
	* @var int
	*/
	protected	$_referenceCode;
	/**
	* Channel code
	* Length: 1
	* @var int
	*/
	protected	$_channelCode;
	/**
	* Serial number
	* Contains a two year unique serial number.
	* Is also used as image key.
	* Length: 12
	* @var string
	*/
	protected	$_serialNumber;
	/**
	* Image marker
	* Tells if a image is connected to the transaction.
	* @var bool
	*/
	protected	$_imageMarker;
	/**
	* Deduction code
	* Used when transaction code is "21"
	* Tells if there are any reminder of the invoice.
	* Length: 1
	* @var int
	*/
	protected	$_deductionCode;
	/**
	* Information
	* Stores data from information post type (25).
	* Up to 99 information posts can be transmitted.
	* Max length of string: 50
	* @var array of strings
	*/
	protected	$_information;
	/**
	* Name of the sender
	* Two strings of names is stored together in this string.
	* Length of strings: 35
	* Max total Length: 70
	* @var string
	*/
	protected	$_name;
	/**
	* Adress1 field stores address and postal number
	* Postal number length: 9
	* Address length: 35
	* @var string
	*/
	protected	$_address1;
	/**
	* Adress2 field stores city, country and countrycode
	* City length: 35
	* Country length: 35
	* Country code length: 2
	* Country and country code are blank if it is a domestic transaction.
	* @var string
	*/
	protected	$_address2;
	/**
	* Sender organisation number
	* Max length: 12
	* @var int
	*/
	protected	$_organisationNumber;

	/**
	* Returns transaction code.
	* @author	Daniel Josefsson
	* @since	v0.1
	*/
	public function getTransactionCode()
	{
		return $this->_transactionCode;
	}

	/**
	* Sets new transaction code.
	* @author	Daniel Josefsson
	* @since	v0.1
	* @param	int $transactionCode
	* @return	BankgiroPaymentsTransaction
	*/
	public function setTransactionCode( $transactionCode )
	{
		$this->_transactionCode = $transactionCode;
		return $this;
	}

	/**
	* Returns sender bankgiro account number.
	* @author	Daniel Josefsson
	* @since	v0.1
	*/
	public function getSenderBankgiroAccountNumber()
	{
		return $this->_senderBankgiroAccountNumber;
	}

	/**
	* Sets new sender bankgiro account number.
	* @author	Daniel Josefsson
	* @since	v0.1
	* @param	int $senderBankgiroAccountNumber
	* @return	BankgiroPaymentsTransaction
	*/
	public function setSenderBankgiroAccountNumber( $senderBankgiroAccountNumber )
	{
		$this->_senderBankgiroAccountNumber = $senderBankgiroAccountNumber;
		return $this;
	}

	/**
	* Returns amount.
	* @author	Daniel Josefsson
	* @since	v0.1
	*/
	public function getAmount()
	{
		return $this->_amount;
	}

	/**
	* Sets new amount.
	* @author	Daniel Josefsson
	* @since	v
	* @param	int $amount
	* @return	BankgiroPaymentsTransaction
	*/
	public function setAmount( $amount )
	{
		$this->_amount = $amount;
		return $this;
	}

	/**
	* Returns reference.
	* @author	Daniel Josefsson
	* @since	v0.1
	*/
	public function getReference()
	{
		return $this->_reference;
	}

	/**
	* Sets new reference.
	* @author	Daniel Josefsson
	* @since	v0.1
	* @param	int $reference
	* @return	BankgiroPaymentsTransaction
	*/
	public function setReference( $reference )
	{
		$this->_reference = $reference;
		return $this;
	}

	/**
	* Returns reference code.
	* @author	Daniel Josefsson
	* @since	v0.1
	*/
	public function getReferenceCode()
	{
		return $this->_referenceCode;
	}

	/**
	* Sets new reference code.
	* @author	Daniel Josefsson
	* @since	v0.1
	* @param	int $referenceCode
	* @return	BankgiroPaymentsTransaction
	*/
	public function setReferenceCode( $referenceCode )
	{
		$this->_referenceCode = $referenceCode;
		return $this;
	}

	/**
	* Returns channel code.
	* @author	Daniel Josefsson
	* @since	v0.1
	*/
	public function getChannelCode()
	{
		return $this->_channelCode;
	}

	/**
	* Sets new channel code.
	* @author	Daniel Josefsson
	* @since	v0.1
	* @param	int $channelCode
	* @return	BankgiroPaymentsTransaction
	*/
	public function setChannelCode( $channelCode )
	{
		$this->_channelCode = $channelCode;
		return $this;
	}

	/**
	* Returns serial number.
	* @author	Daniel Josefsson
	* @since	v0.1
	*/
	public function getSerialNumber()
	{
		return $this->_serialNumber;
	}

	/**
	* Sets new serial number.
	* @author	Daniel Josefsson
	* @since	v0.1
	* @param	int $serialNumber
	* @return	BankgiroPaymentsTransaction
	*/
	public function setSerialNumber( $serialNumber )
	{
		$this->_serialNumber = $serialNumber;
		return $this;
	}

	/**
	* Returns image marker.
	* @author	Daniel Josefsson
	* @since	v0.1
	*/
	public function getImageMarker()
	{
		return $this->_imageMarker;
	}

	/**
	* Sets new image marker.
	* @author	Daniel Josefsson
	* @since	v0.1
	* @param	int $imageMarker
	* @return	BankgiroPaymentsTransaction
	*/
	public function setImageMarker( $imageMarker )
	{
		$this->_imageMarker = $imageMarker;
		return $this;
	}

	/**
	* Returns deduction code.
	* @author	Daniel Josefsson
	* @since	v0.1
	*/
	public function getDeductionCode()
	{
		return $this->_deductionCode;
	}

	/**
	* Sets new deduction code.
	* @author	Daniel Josefsson
	* @since	v0.1
	* @param	int $deductionCode
	* @return	BankgiroPaymentsTransaction
	*/
	public function setDeductionCode( $deductionCode )
	{
		$this->_deductionCode = $deductionCode;
		return $this;
	}

	/**
	* Returns information.
	* @author	Daniel Josefsson
	* @since	v0.1
	*/
	public function getInformation()
	{
		return $this->_information;
	}

	/**
	* Sets new information.
	* @author	Daniel Josefsson
	* @since	v0.1
	* @param	int $information
	* @return	BankgiroPaymentsTransaction
	*/
	public function setInformation( $information )
	{
		$this->_information = $information;
		return $this;
	}

	/**
	* Returns name.
	* @author	Daniel Josefsson
	* @since	v0.1
	*/
	public function getName()
	{
		return $this->_name;
	}

	/**
	* Sets new name.
	* @author	Daniel Josefsson
	* @since	v0.1
	* @param	int $name
	* @return	BankgiroPaymentsTransaction
	*/
	public function setName( $name )
	{
		$this->_name = $name;
		return $this;
	}

	/**
	* Returns address1.
	* @author	Daniel Josefsson
	* @since	v0.1
	*/
	public function getAddress1()
	{
		return $this->_address1;
	}

	/**
	* Sets new address1.
	* @author	Daniel Josefsson
	* @since	v0.1
	* @param	int $address1
	* @return	BankgiroPaymentsTransaction
	*/
	public function setAddress1( $address1 )
	{
		$this->_address1 = $address1;
		return $this;
	}

	/**
	* Returns address2.
	* @author	Daniel Josefsson
	* @since	v0.1
	*/
	public function getAddress2()
	{
		return $this->_address2;
	}

	/**
	* Sets new address2.
	* @author	Daniel Josefsson
	* @since	v0.1
	* @param	int $address2
	* @return	BankgiroPaymentsTransaction
	*/
	public function setAddress2( $address2 )
	{
		$this->_address2 = $address2;
		return $this;
	}

	/**
	* Returns organisation number.
	* @author	Daniel Josefsson
	* @since	v0.1
	*/
	public function getOrganisationNumber()
	{
		return $this->_organisationNumber;
	}

	/**
	* Sets new organisation number.
	* @author	Daniel Josefsson
	* @since	v0.1
	* @param	int $organisationNumber
	* @return	BankgiroPaymentsTransaction
	*/
	public function setOrganisationNumber( $organisationNumber )
	{
		$this->_organisationNumber = $organisationNumber;
		return $this;
	}

}
