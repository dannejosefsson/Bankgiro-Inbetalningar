<?php
/**
 * End post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Parser;

use BGI\Row\Object as Object;

/**
 * End post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractParser
 */
class End extends AbstractParser
{
	/**
	 * {@inheritdoc}
	 */
	protected $_validTransactionCodes = array('70');

	const STATE_END_POST_PARSED		= 'End post parsed';

	/**
	 * {@inheritdoc}
	 */
	public function checkSyntax($rowData)
	{
		$regex = "/^[0-9]{8}[0-9]{8}[0-9]{8}[0-9]{8}[\s]{0,46}[\r]{0,1}[\n]{1}$/";
		return (preg_match($regex, $rowData))? true: false;
	}

	/**
	 * {@inheritdoc}
	 * @uses	checkSyntax($rowData)
	 */
	public function parseRow($transactionCode, $rowData)
	{
		if (	$this->checkTransactionCode($transactionCode) &&
				$this->checkSyntax($rowData))
		{
			$data = array();
			$returnObject = $this->getObject($data);
			$returnObject->setTransactionCode($transactionCode);
			// Get payment posts count;
			$start = 0;
			$length = 8;
			$returnObject->setPaymentPostsCount(
				(int) substr($rowData, $start, $length));
			// Get deduction posts count;
			$start = $start + $length;
			$length = 8;
			$returnObject->setDeductionPostsCount(
				(int) substr($rowData, $start, $length));
			// Get extra references posts count;
			$start = $start + $length;
			$length = 8;
			$returnObject->setExtraReferencePostsCount(
				(int) substr($rowData, $start, $length));
			// Get deposit posts count;
			$start = $start + $length;
			$length = 8;
			$returnObject->setDepositPostsCount(
				(int) substr($rowData, $start, $length));

			// The rest is empty, so it is no need to save that.
			$this->_state = self::STATE_END_POST_PARSED;
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
	protected function getObject(array $data = array())
	{
		if (!$this->_objectType instanceof Object\ObjectInterface &&
			!$this->_objectType instanceof Object\EndInterface)
		{
			return $this->_objectType = new Object\End();
		}
		else
		{
			return $this->_objectType->setData($data);
		}
	}
}
