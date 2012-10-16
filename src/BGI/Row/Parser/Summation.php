<?php
/**
 * Summation post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Parser;

use BGI\Row\Object as Object;

/**
 * Summation post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractParser
 */
class Summation extends AbstractParser
{
	/**
	 * {@inheritdoc}
	 */
	protected $_validTransactionCodes = array('15');

	const STATE_SUMMATION_POST_PARSED		= 'Summation post parsed';

	/**
	 * {@inheritdoc}
	 */
	public function checkSyntax($rowData)
	{
		$regex = "/^[0-9]{35}[0-9]{8}[0-9]{5}[0-9]{18}[A-Z]{3}[0-9]{8}[DKS\s]{1}$/";
		return (preg_match($regex, $rowData))? true: false;
	}

	/**
	 * {@inheritdoc}
	 * @uses	checkSyntax($rowData)
	 */
	public function parseRow($transactionCode, $rowData)
	{
		if ($this->checkSyntax($rowData))
		{
			$data = array();
			$returnObject = $this->getObject($data);
			$returnObject->setTransactionCode($transactionCode);
			// Get receiver bank account number;
			$start = 0;
			$length = 35;
			$returnObject->setReceiverBankAccountNumber(
				(int) substr($rowData, $start, $length));
			// Get deposit date
			$start = $start + $length;
			$length = 8;
			$returnObject->setDepositDate(
				date('Y-m-d', strtotime(substr($rowData, $start, $length))));
			// Get deposit number
			$start = $start + $length;
			$length = 5;
			$returnObject->setDepositNumber((int) substr($rowData, $start, $length));
			// Get deposit value
			$start = $start + $length;
			$length = 18;
			$returnObject->setDepositValue((int) substr($rowData, $start, $length));
			// Get currency
			$start = $start + $length;
			$length = 3;
			$returnObject->setCurrency(substr($rowData, $start, $length));
			// Get number of transactions
			$start = $start + $length;
			$length = 8;
			$returnObject->setTransactionsCount((int) substr($rowData, $start, $length));
			// Get deposit type
			$start = $start + $length;
			$length = 1;
			$returnObject->setDepositType(substr($rowData, $start, $length));

			// The rest is empty, so it is no need to save that.
			$this->_state = self::STATE_SUMMATION_POST_PARSED;
			return $returnObject;
		}
		else
		{
			return false;
		}
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getObject(array $data)
	{
		if (	!$this->_objectType instanceof Object\ObjectInterface &&
				!$this->_objectType instanceof Object\SummationInterface)
		{
			return $this->_objectType = new Object\Summation();
		}
		else
		{
			return $this->_objectType->setData($data);
		}
	}
}
