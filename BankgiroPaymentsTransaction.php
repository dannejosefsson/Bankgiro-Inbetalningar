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
class BankgiroPaymentsTransaction
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
	* Max length of strings: 35
	* Max total Length: 70
	* @var string
	*/
	protected	$_names;
	/**
	* Adress1 field stores address and postal number
	* Address max length: 35
	* Postal number max length: 9
	* @var array
	*/
	protected	$_address1;
	/**
	* Adress2 field stores city, country and countrycode
	* City max length: 35
	* Country max length: 35
	* Country max code length: 2
	* Country and country code are blank if it is a domestic transaction.
	* @var array
	*/
	protected	$_address2;
	/**
	* Sender organisation number
	* Max length: 12
	* @var int
	*/
	protected	$_organisationNumber;

	/**
	* Array with extra references
	* @var array of BankgiroPaymentTransaction
	 */
	protected	$_extraReferences;

	/**
	*
	* @since	v0.2
	*/
	public function __construct()
	{
		$this->_names = array();
		$this->_extraReferences = array();
	}

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
		$this->_information[] = $information;
		return $this;
	}

	/**
	* Returns name.
	* @author	Daniel Josefsson
	* @since	v0.1
	*/
	public function getNames( $index )
	{
		return $this->_names[$index];
	}

	/**
	* Sets new name.
	* @author	Daniel Josefsson
	* @since	v0.1
	* @param	int $name
	* @return	BankgiroPaymentsTransaction
	*/
	public function setNames( $names = array() )
	{
		$this->_names[] = $names;
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

	/**
	* Returns extra references.
	* @author	Daniel Josefsson
	* @since	v0.2
	* @return	array of BankgiroPaymentsTransaction
	*/
	public function getExtraReferences()
	{
		return $this->_extraReferences;
	}

	/**
	* Sets new extra reference.
	* @author	Daniel Josefsson
	* @since	v0.2
	* @param	BankgiroPaymentsTransaction $extraReference
	* @return	BankgiroPaymentsTransaction $this
	*/
	public function setExtraReference( BankgiroPaymentsTransaction $extraReference )
	{
		$this->_extraReferences[] = $extraReference;
		return $this;
	}

	/**
	* Return index to the latest inserted extra reference.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @return	int $keyToExtraReference
	*/
	public function lastExtraReferenceIndex()
	{
		end($this->_extraReferences);
		return key($this->_extraReferences);
	}

	/**
	* Returns wanted extra reference
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @param 	int $index
	* @return	BankgiroPaymentsTransaction $extraReference
	*/
	public function getExtraReference( $index )
	{
		return $this->_extraReferences[$index];
	}

	/**
	* Add new extra reference.
	* Increments reference count.
	* @author	Daniel Josefsson
	* @since	v0.2
	* @param	string 						$postType
	* @return	BankgiroPaymentsTransaction $this
	*/
	public function addExtraReference($postType)
	{
		$this->_extraReferences[] = new BankgiroPaymentsTransaction();

		return $this;
	}

	/**
	* Return the extra references count.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @return	int
	*/
	public function getExtraReferencesCount()
	{
		return sizeof($this->_extraReferences);
	}

	/**
	* Parses line,given with the syntax of posts 20 to 29 in Bankgiro Inbetalningar.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @param	string $line
	* @return	boolean
	*/
	public function parsePost( $line )
	{
		$return = false;
		$postType = substr($line, 0, 2);
		$postData = substr($line, 2);
		switch ($postType)
		{
			case '20':
				$return = $this->parsePaymentPost($line);
				break;
			case '21':
				$return = $this->parseDeductionPost($line);
				break;
			case '22':
			case '23':
				$extraReferenceIndex = $this->addExtraReference($postType)->lastExtraReferenceIndex();
				$return = $this->getExtraReference($extraReferenceIndex)->parsePaymentPost($line);

				break;
			case '25':
				$return = $this->parseInformationPost($postData);
				break;
			case '26':
				$return = $this->parseNamePost($postData);
				break;
			case '27':
				$return = $this->parseAddress1Post($postData);
				break;
			case '28':
				$return = $this->parseAddress2Post($postData);
				break;

			default:
				break;
		}
		return $return;
	}

	/**
	* Parses payment post (20).
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @param 	string	$post
	* @return	bool
	*/
	private function parsePaymentPost( $post )
	{
		$this->setTransactionCode(substr($post, 0, 2));
		$this->setSenderBankgiroAccountNumber((int) substr($post, 2, 10));
		$this->setReferenceCode((int) substr($post, 55, 1));
		$this->setReference(trim(substr($post, 12, 25), ' '));
		$this->setAmount((int) substr($post, 37, 18));
		$this->setChannelCode((int) substr($post, 56, 1));
		$this->setSerialNumber(substr($post, 57, 12));
		$this->setImageMarker((int) substr($post, 69, 1));
		// Reserved placeholders (post[70-79]) are not used.
		return true;
	}

	/**
	* Parses deduction post (21).
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @param 	string				$post
	* @return	bool
	*/
	private function parseDeductionPost( $post )
	{
		$this->parsePaymentPost($post);
		$this->setDeductionCode((int) substr($post, 70, 1));
		// Reserved placeholders (post[70-79]) are not used.
		return true;
	}

	/**
	* Parses information post (25).
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @param 	string	$postData
	* @return	bool
	*/
	private function parseInformationPost( $postData )
	{
		$this->setInformation(trim(substr($postData, 0, 50), ' '));
		// Reserved placeholders (postData[50-77]) are not used.
		return true;
	}

	/**
	* Parses name post (26).
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @param 	string	$postData
	* @return	bool
	*/
	private function parseNamePost( $postData )
	{
		$this->setNames(array(	trim(substr($postData, 0, 35), ' '),
								trim(substr($postData, 35, 35), ' ')));
		// Reserved placeholders (postData[70-77]) are not used.
		return true;
	}

	/**
	* Parses first address post (27).
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @param 	string	$postData
	* @return	bool
	*/
	private function parseAddress1Post( $postData )
	{
		$this->setAddress1(array(	trim(substr($postData, 0, 35), ' '),
										trim(substr($postData, 35, 9), ' ')));
		// Reserved placeholders (postData[44-77]) are not used.
		return true;
	}

	/**
	* Parses second address post (28).
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @since	v0.2
	* @param 	string	$postData
	* @return	bool
	*/
	private function parseAddress2Post( $postData )
	{
		$this->setAddress2(array(	trim(substr($postData, 0, 35), ' '),
										trim(substr($postData, 35, 35), ' '),
										trim(substr($postData, 70, 2)))		);
		// Reserved placeholders (postData[72-77]) are not used.
		return true;
	}
}
