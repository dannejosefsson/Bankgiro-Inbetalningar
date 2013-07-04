<?php
/**
 * The transaction stage container.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\InfoContainer;

use BGI\Row\Object as Object;
use BGI\Row\Parser as Parser;

/**
 * The transaction stage container
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractInfoContainer
 * @uses		TransactionInterface
 */
class Transaction	extends AbstractInfoContainer
					implements TransactionInterface
{
	/** #@+ @access */
	/**
	 * {@inheritdoc}
	 */
	protected static $_startPostTransactionCode = array(
			Object\TransactionInterface::TRANSACTION_CODE_TR,
			Object\TransactionInterface::TRANSACTION_CODE_DE);

	/**
	 * Stores the transaction object.
	 * @var Object\TransactionInterface
	 */
	protected $_transaction;

	/**
	 * Stores the name object.
	 * @var Object\NameInterface
	 */
	protected $_name;

	/**
	 * Stores the extra references objects.
	 * @var array	Contains Object\TranscationInterface
	 */
	protected $_extraReferences = array();

	/**
	 * Stores the information object.
	 * @var array Contains Object\InformationInterface
	 */
	protected $_information = array();

	/**
	 * Stores the address one object.
	 * @var Object\AddressOneInterface
	 */
	protected $_addressOne;

	/**
	 * Stores the address two object.
	 * @var Object\AddressTwoInterface
	 */
	protected $_addressTwo;

	/**
	 * Stores the organistation number object.
	 * @var Object\OrganisationNumberInterface
	 */
	protected $_organisationNumber;

	/**
	 * Transaction count.
	 * @var int
	 */
	protected $_transactionCount = 0;
	/** #@- */

	/** #@+ State */
	const STATE_PAYMENT_POST_PARSED				= 'Payment post parsed';
	const STATE_DEDUCTION_POST_PARSED			= 'Deduction post parsed';
	const STATE_EXTRA_REFERENCE_POST_PARSED		= 'Extra reference post parsed';
	const STATE_NAME_POST_PARSED				= 'Name post parsed';
	const STATE_ADDRESS_ONE_POST_PARSED			= 'Address one post parsed';
	const STATE_ADDRESS_TWO_POST_PARSED			= 'Address two post parsed';
	const STATE_INFORMATION_POST_PARSED			= 'Information post parsed';
	const STATE_ORGANISATION_NUMBER_POST_PARSED
				= 'Organisation number post parsed';
	/** #@- */

	/**
	 * {@inheritdoc}
	 */
	public function __construct()
	{
		$parserFactory = new Parser\Factory();
		$this->setRowParser(static::$_startPostTransactionCode[0],
				$parserFactory->getParser(Parser\TransactionInterface::_name));
		$this->setRowParser(static::$_startPostTransactionCode[1],
				$parserFactory->getParser(Parser\TransactionInterface::_name));
		$this->setRowParser(Object\TransactionInterface::TRANSACTION_CODE_TR_ER,
				$parserFactory->getParser(Parser\TransactionInterface::_name));
		$this->setRowParser(Object\TransactionInterface::TRANSACTION_CODE_DE_ER,
				$parserFactory->getParser(Parser\TransactionInterface::_name));
		$this->setRowParser(Object\NameInterface::TRANSACTION_CODE,
				$parserFactory->getParser(Parser\NameInterface::_name));
		$this->setRowParser(Object\AddressOneInterface::TRANSACTION_CODE,
				$parserFactory->getParser(Parser\AddressOneInterface::_name));
		$this->setRowParser(Object\AddressTwoInterface::TRANSACTION_CODE,
				$parserFactory->getParser(Parser\AddressTwoInterface::_name));
		$this->setRowParser(Object\OrganisationNumberInterface::TRANSACTION_CODE,
				$parserFactory->getParser(Parser\OrganisationNumberInterface::_name));
		$this->setRowParser(Object\InformationInterface::TRANSACTION_CODE,
				$parserFactory->getParser(Parser\InformationInterface::_name));
	}

	/**
	 * {@inheritdoc}
	 */
	public function handleObject(Object\ObjectInterface $object)
	{
		if ($object instanceof Object\TransactionInterface)
		{
			$transactionCode = $object->getTransactionCode();
			switch ($transactionCode)
			{
				case static::$_startPostTransactionCode[0]:
				case static::$_startPostTransactionCode[1]:
					$this->_transaction = $object;
					$this->addTransactionCount();
					break;
				case Object\TransactionInterface::TRANSACTION_CODE_TR_ER:
				case Object\TransactionInterface::TRANSACTION_CODE_DE_ER:
					$this->_extraReferences[] = $object;
					break;
				default:
				break;
			}
		}
		elseif ($object instanceof Object\NameInterface)
		{
			$this->_name = $object;
		}
		elseif ($object instanceof Object\InformationInterface)
		{
			$this->_information[] = $object;
		}
		elseif ($object instanceof Object\AddressOneInterface)
		{
			$this->_addressOne = $object;
		}
		elseif ($object instanceof Object\AddressTwoInterface)
		{
			$this->_addressTwo = $object;
		}
		elseif ($object instanceof Object\OrganisationNumberInterface)
		{
			$this->_organisationNumber = $object;
		}
		else
		{
		}
		return true;
	}

	/**
	 * Att to transaction count
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int $int
	 * @access	protected
	 * @uses	Transaction::$_transactionCount
	 */
	protected function addTransactionCount($int = null)
	{
		if (is_numeric($int))
		{
			$this->_transactionCount + $int;
		}
		else
		{
			$this->_transactionCount++;
		}
	}

	/**
	 * {@inheritdoc}
	 * @uses	Transaction::$_transactionCount
	 */
	public function getTransactionsCount()
	{
		return $this->_transactionCount;
	}

	/**
	 * {@inheritdoc}
	 * @uses	Transaction::$_transaction
	 */
	public function getPaymentValue()
	{
		if (is_numeric($this->_transaction->getDeductionCode()))
		{
			return -$this->_transaction->getPaymentValue();
		}
		else
		{
			return $this->_transaction->getPaymentValue();
		}
	}

	/**
	 * {@inheritdoc}
	 * @uses	Transaction::$_extraReferences
	 */
	public function countExtraReferences()
	{
		if (is_array($this->_extraReferences))
		{
			return count($this->_extraReferences);
		}
		else
		{
			return 0;
		}
	}

	/**
	 * {@inheritdoc}
	 * @uses	Transaction::$_transactionCount
	 */
	public function getTransactionCode()
	{
		if ($this->_transaction instanceof Object\ObjectInterface)
		{
			return $this->_transaction->getTransactionCode();
		}
	}
}

