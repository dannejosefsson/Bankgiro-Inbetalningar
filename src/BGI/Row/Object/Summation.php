<?php
/**
 * Summation object.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Object;

/**
 * Summation object.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractObject
 * @uses		SummationInterface
 */
class Summation extends AbstractObject implements SummationInterface
{
	/**#@+ @access protected */
	/**
	 * Receiver bank account number.
	 * @var int|string
	 */
	protected $_receiverBankAccountNumber;

	/**
	 * Deposit date.
	 * @var string
	 */
	protected $_depositDate;

	/**
	 * Deposit number.
	 * @var int|string
	 */
	protected $_depositNumber;

	/**
	 * Deposit value.
	 * @var int
	 */
	protected $_depositValue;

	/**
	 * Currency.
	 * @var string
	 */
	protected $_currency;

	/**
	 * Transaction count.
	 * @var int
	 */
	protected $_transactionCount;

	/**
	 * Deposit type.
	 * @var int|string
	 */
	protected $_depositType;
	/**#@- */

	/**
	 * {@inheritdoc}
	 * @return Summation
	 */
	public function setData(array $data)
	{
		foreach ($data as $key => $value)
		{
			switch ($key)
			{
				case 'receiverBankAccountNumber':
					$this->setReceiverBankAccountNumber($value);
					break;
				case 'depositDate':
					$this->setDepositDate($value);
					break;
				case 'depositNumber':
					$this->setDepositNumber($value);
					break;
				case 'depositValue':
					$this->setDepositValue($value);
					break;
				case 'currency':
					$this->setCurrency($value);
					break;
				case 'transactionCount':
					$this->setTransactionsCount($value);
					break;
				case 'depositType':
					$this->setDepositType($value);
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
	public function getReceiverBankAccountNumber()
	{
		return $this->_receiverBankAccountNumber;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDepositDate()
	{
		return $this->_depositDate;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDepositNumber()
	{
		return $this->_depositNumber;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDepositValue()
	{
		return $this->_depositValue;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCurrency()
	{
		return $this->_currency;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getTransactionsCount()
	{
		return $this->_transactionCount;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDepositType()
	{
		return $this->_depositType;
	}

	/**
	 * {@inheritdoc}
	 * @return Summation
	 */
	public function setReceiverBankAccountNumber($bankAccountNumber)
	{
		$this->_receiverBankAccountNumber = $bankAccountNumber;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return Summation
	 */
	public function setDepositDate($depositDate)
	{
		$this->_depositDate = $depositDate;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return Summation
	 */
	public function setDepositNumber($depositNumber)
	{
		$this->_depositNumber = $depositNumber;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return Summation
	 */
	public function setDepositValue($depositValue)
	{
		$this->_depositValue = $depositValue;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return Summation
	 */
	public function setCurrency($currency)
	{
		$this->_currency = $currency;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return Summation
	 */
	public function setTransactionsCount($transactionCount)
	{
		$this->_transactionCount = $transactionCount;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return Summation
	 */
	public function setDepositType($depositType)
	{
		$this->_depositType = $depositType;
		return $this;
	}
}
