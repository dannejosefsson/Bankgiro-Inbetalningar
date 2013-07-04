<?php
/**
 * Holds one of possibly several deposit stages.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\InfoContainer;

use BGI\Row\Object as Object;
use BGI\Row\Parser as Parser;

/**
 * Holds one of possibly several deposit stages.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
class Deposit extends AbstractInfoContainer
{
	/**#@+ @access protected */
	/**
	 * Start post transaction code.
	 * @static
	 * @var string
	 */
	protected static $_startPostTransactionCode =
		Object\OpeningInterface::TRANSACTION_CODE;

	/**
	 * End post transaction code.
	 * @var string
	 */
	protected static $_endPostTransactionCode =
		Object\SummationInterface::TRANSACTION_CODE;

	/**
	 * Opening post object.
	 * @var Object\OpeningInterface
	 */
	protected	$_openingObject;

	/**
	 * Summation post object.
	 * @var Opening\SummationInterface
	 */
	protected $_summationObject;

	/**
	 * The count of the different transaction types is stored in this array.
	 * @var array
	 */
	protected $_transactionTypeCount = array(	'payment'			=> 0,
												'deduction'			=> 0,
												'extraReferences'	=> 0,);
	/**#@- */

	const STATE_OPENING_POST_PARSED		= 'Opening post parsed';
	const STATE_SUMMATION_POST_PARSED	= 'Summation post parsed';

	/**
	 * {@inheritdoc}
	 */
	public function __construct()
	{
		$parserFactory = new Parser\Factory();
		$this->setRowParser($this->getStartTransactionCode(),
				$parserFactory->getParser(Parser\OpeningInterface::_name));
		$this->setRowParser(static::$_endPostTransactionCode,
				$parserFactory->getParser(Parser\SummationInterface::_name));
		$this->setLowerLevelInfoContainerType(
				InfoContainerFactory::getTransaction());
	}

	/**
	 * {@inheritdoc}
	 */
	public function handleObject(Object\ObjectInterface $object)
	{
		if ($object instanceof Object\OpeningInterface)
		{
			$this->setState(self::STATE_OPENING_POST_PARSED);
			$this->_openingObject = $object;
		}
		elseif ($object instanceof Object\SummationInterface)
		{
			if(strcmp($this->getState(), self::STATE_OPENING_POST_PARSED))
			{
				$errorMessage = 'The container must be in following '.
					'state: "' . self::STATE_OPENING_POST_PARSED .
					'" to be able to parse the summation post.';
				$this->setError($errorMessage);
				return $this->getState();
			}

			// Make sure that the right amount of transactions are parsed
			$parsed = $this->countTransactions();
			$countInPost = $object->getTransactionsCount();
			if ($parsed != $countInPost)
			{
				$errorMsg = 'The transactions count is not consistent. '.
					'Parsed: ' . $parsed . '. In post: ' . $countInPost;
				$this->setError($errorMsg);
				return $this->getState();
			}

			// Make sure that the parsed transactions have the same payment
			// value as the summation post.
			$transPayments = $this->getPaymentValueFromTransactions();
			$summationPaymentValue = $object->getDepositValue();
			if ($transPayments != $summationPaymentValue)
			{
				$errorMsg = 'The summation payment value is not consistent ' .
					'with parsed transactions. '.
					'Parsed: ' . $transPayments . '. ' .
					'In post:' . $summationPaymentValue. '.';
				$this->setError($errorMsg);
				return false;
			}

			// Make sure that the currency is consistent.
			$summationCurrency = $object->getCurrency();
			if (strcmp($this->_openingObject->getCurrency(), $summationCurrency))
			{
				$errorMsg = "The summation currency is not consistent " .
					'with the parsed one.' .
					'Parsed: ' . $summationCurrency . '. ' .
					'In post:' . $this->_currency. '.';
				$this->setError($errorMsg);
				return false;
			}

			$this->countTransactionTypes();

			$this->setState(self::STATE_SUMMATION_POST_PARSED);
			$this->_summationObject = $object;
		}
		return true;
	}

	/**
	 * Count parsed transactions.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @access	protected
	 * @uses	Deposit::$_lowerLevelInfoContainers
	 */
	protected function countTransactions()
	{
		if(is_array($this->_lowerLevelInfoContainers))
			return count($this->_lowerLevelInfoContainers);
		else
			return 0;
	}

	/**
	 * Adds a transaction to the specific transaction type count
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	string $type
	 * @param	int $amount
	 * @uses	Deposit::$_transactionTypeCount
	 * @throws InfoContainerException
	 */
	protected function addTransactionType($type, $amount = 1)
	{
		if (!key_exists($type, $this->_transactionTypeCount))
		{
			throw new InfoContainerException($type . ' is not a valid key.');
		}
		$this->_transactionTypeCount[$type] += $amount;
	}

	/**
	 * Count the transactions according to type.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @uses	Deposit::$_lowerLevelInfoContainers
	 * @uses	Deposit::addTransactionType()
	 * @uses	Deposit::setError()
	 */
	protected function countTransactionTypes()
	{
		if (is_array($this->_lowerLevelInfoContainers))
		{
			foreach ($this->_lowerLevelInfoContainers as $transaction)
			{
				switch ($transactionCode = $transaction->getTransactionCode())
				{
					case Object\TransactionInterface::TRANSACTION_CODE_TR:
						$this->addTransactionType('payment');
						$this->addTransactionType('extraReferences',
							$transaction->countExtraReferences());
						break;
					case Object\TransactionInterface::TRANSACTION_CODE_DE:
						$this->addTransactionType('deduction');
						$this->addTransactionType('extraReferences',
							$transaction->countExtraReferences());
						break;
					default:
						$errorMsg = 'Faulty transaction code found: ';
						$errorMsg .= $transactionCode;
						$this->setError($errorMsg);
					break;
				}
			}
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function getTransactionTypeCount()
	{
		return $this->_transactionTypeCount;
	}

	/**
	 * Count the payment value from parsed transactions.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @uses	Deposit::$_lowerLevelInfoContainers
	 * @uses	TransactionInterface::getPaymentValue()
	 */
	protected function getPaymentValueFromTransactions()
	{
		$paymentValue = 0;
		foreach ($this->_lowerLevelInfoContainers as $transaction)
		{
			$paymentValue += $transaction->getPaymentValue();
		}
		return $paymentValue;
	}

}
