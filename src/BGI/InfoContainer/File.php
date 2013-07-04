<?php
/**
 * Contains the top level information of the file.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\InfoContainer;

use BGI\Visitor\VisitorInterface;

use BGI\Visitor\VisitInfoContainerInterface;

use BGI\Row\Object as Object;
use BGI\Row\Parser as Parser;

/**
 * Contains the top level information of the file.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractInfoContainer
 */
class File extends AbstractInfoContainer
{
	/**#@+ @access protected */
	/**
	 * {@inheritdoc}
	 */
	protected static $_startPostTransactionCode =
		Object\StartInterface::TRANSACTION_CODE;

	/**
	 * End post transaction code.
	 * @var string
	 */
	protected static $_endPostTransactionCode =
		Object\EndInterface::TRANSACTION_CODE;

	/**
	 * Start post object.
	 * @var Object\StartInterface
	 */
	protected $_startObject;

	/**
	 * End post object.
	 * @var Object\EndInterface
	 */
	protected $_endObject;
	/**#@- */

	const STATE_START_POST_PARSED		= 'Start post parsed';
	const STATE_END_POST_PARSED			= 'End post parsed';

	/**
	 * {@inheritdoc}
	 */
	public function __construct()
	{
		$parserFactory = new Parser\Factory();
		$this->setRowParser(	$this->getStartTransactionCode(),
			$parserFactory->getParser(Parser\StartInterface::_name));
		$this->setRowParser(	static::$_endPostTransactionCode,
			$parserFactory->getParser(Parser\EndInterface::_name));
		$this->setLowerLevelInfoContainerType(
				InfoContainerFactory::getDeposit());
	}

	/**
	 * {@inheritdoc}
	 */
	public function handleObject(Object\ObjectInterface $object)
	{
		if ($object instanceof Object\StartInterface)
		{
			$this->setState(self::STATE_START_POST_PARSED);
			$this->_startObject= $object;
		}
		elseif ($object instanceof Object\EndInterface)
		{
			if(strcmp($this->getState(), self::STATE_START_POST_PARSED))
			{
				$errorMessage = 'The container must be in following '.
					'state: "' . self::STATE_START_POST_PARSED .
					'" to be able to parse the end post.';
				$this->setError($errorMessage);
			}
			//TODO: Program to an interface, not an implementation.
			if (is_array($counts = $this->countDepositsAndTransactionTypes()))
			{
				$this->checkConsistancy($counts['deposits'],
					$object->getDepositPostsCount(), 'Deposits');
				$this->checkConsistancy($counts['payment'],
					$object->getPaymentPostsCount(), 'Payment posts');
				$this->checkConsistancy($counts['deduction'],
					$object->getDeductionPostsCount(), 'Deduction posts');
				$this->checkConsistancy($counts['extraReferences'],
					$object->getExtraReferencePostsCount(),
						'Extra references posts');
			}

			if (strcmp($this->getState(), self::STATE_ERROR))
			{
				$this->setState(self::STATE_END_POST_PARSED);
			}
			$this->_endObject = $object;
		}
		return $this->getState();
	}

	/**
	 * Count deposit and transaction types to be able to check consistency.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 */
	protected function countDepositsAndTransactionTypes()
	{
		if (is_array($this->_lowerLevelInfoContainers))
		{
			$depositsTransactions = array('deposits' => 0);
			foreach ($this->_lowerLevelInfoContainers as $deposit)
			{
				$depositsTransactions['deposits']++;
				$arrTr = $deposit->getTransactionTypeCount();
				foreach ($arrTr as $type => $count)
				{
					if (key_exists($type, $depositsTransactions))
					{
						$depositsTransactions[$type] += $count;
					}
					else
					{
						$depositsTransactions[$type] = $count;
					}
				}
			}
			return $depositsTransactions;
		}
		else
		{
			return false;
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function accept(VisitorInterface $visitor) {
		$visitor->visitInfoContainer($this);
	}
}
