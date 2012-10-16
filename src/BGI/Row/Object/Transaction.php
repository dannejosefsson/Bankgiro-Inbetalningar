<?php
/**
 * Transaction object.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Object;

/**
 * Transaction object.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractObject
 * @uses		TransactionInterface
 */
class Transaction extends AbstractObject implements TransactionInterface
{
	/**#@+ @access protected */
	/**
	 * Sender bankgiro
	 * @var string
	 */
	protected $_senderBankgiro;

	/**
	 * References.
	 * @var array
	 */
	protected $_references;

	/**
	 * Payment value
	 * @var int
	 */
	protected $_paymentValue;

	/**
	 * Reference code.
	 * @var int|string
	 */
	protected $_referenceCode;

	/**
	 * Payment channel.
	 * @var int|string
	 */
	protected $_paymentChannel;

	/**
	 * BGC refernece number.
	 * @var int|string
	 */
	protected $_bgcReferenceNumber;

	/**
	 * Depicture marker.
	 * @var int|string
	 */
	protected $_depictureMarker;

	/**
	 * Deduction code.
	 * @var int|string
	 */
	protected $_deductionCode;
	/**#@- */

	/**
	 * {@inheritdoc}
	 * @return	Transaction
	 */
	public function setData(array $data)
	{
		foreach ($data as $key => $value)
		{
			switch ($key)
			{
				case 'senderBankgiro':
					$this->setSenderBankgiro($value);
					break;
				case 'reference':
					$this->setReference($value);
					break;
				case 'paymentValue':
					$this->setPaymentValue($value);
					break;
				case 'referenceCode':
					$this->setReferenceCode($value);
					break;
				case 'paymentChannel':
					$this->setPaymentChannel($value);
					break;
				case 'bgcReferenceNumber':
					$this->setBgcReferenceNumber($value);
					break;
				case 'depictureMarker':
					$this->setDepictureMarker($value);
					break;
				default:
					parent::setDatum($key, $value);
					break;
			}
		}
		return $this;
	}


	/**
	 * {@inheritdoc}
	 */
	public function getSenderBankgiro()
	{
		return $this->_senderBankgiro;
	}


	/**
	 * {@inheritdoc}
	 */
	public function getReferences()
	{
		return $this->_references;
	}


	/**
	 * {@inheritdoc}
	 */
	public function getPaymentValue()
	{
		return $this->_paymentValue;
	}


	/**
	 * {@inheritdoc}
	 */
	public function getReferenceCode()
	{
		return $this->_referenceCode;
	}


	/**
	 * {@inheritdoc}
	 */
	public function getPaymentChannel()
	{
		return $this->_paymentChannel;
	}


	/**
	 * {@inheritdoc}
	 */
	public function getBgcReferenceNumber()
	{
		return $this->_bgcReferenceNumber;
	}


	/**
	 * {@inheritdoc}
	 */
	public function getDepictureMarker()
	{
		return $this->_depictureMarker;
	}


	/**
	 * {@inheritdoc}
	 */
	public function getDeductionCode()
	{
		return $this->_deductionCode;
	}

	/**
	 * {@inheritdoc}
	 * @return Transaction
	 */
	public function setSenderBankgiro($senderBankgiro)
	{
		$this->_senderBankgiro = $senderBankgiro;
		return $this;
	}


	/**
	 * {@inheritdoc}
	 * @return Transaction
	 */
	public function setReferences(array $references)
	{
		$this->_references = $references;
		return $this;
	}


	/**
	 * {@inheritdoc}
	 * @return Transaction
	 */
	public function setPaymentValue($value)
	{
		$this->_paymentValue = $value;
		return $this;
	}


	/**
	 * {@inheritdoc}
	 * @return Transaction
	 */
	public function setReferenceCode($referenceCode)
	{
		$this->_referenceCode = $referenceCode;
		return $this;
	}


	/**
	 * {@inheritdoc}
	 * @return Transaction
	 */
	public function setPaymentChannel($paymentChannel)
	{
		$this->_paymentChannel = $paymentChannel;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return Transaction
	 */
	public function setBgcReferenceNumber($referenceNumber)
	{
		$this->_bgcReferenceNumber = $referenceNumber;
		return $this;
	}


	/**
	 * {@inheritdoc}
	 * @return Transaction
	 */
	public function setDepictureMarker($depictureMarker)
	{
		$this->_depictureMarker = $depictureMarker;
		return $this;
	}


	/**
	 * {@inheritdoc}
	 * @return Transaction
	 */
	public function setDeductionCode($deductionCode)
	{
		$this->_deductionCode = $deductionCode;
	}
}
