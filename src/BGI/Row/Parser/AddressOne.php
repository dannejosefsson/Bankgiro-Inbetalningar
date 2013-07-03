<?php
/**
 * AddressOne post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractParser
 */
namespace BGI\Row\Parser;

use BGI\Row\Object as Object;

/**
 * AddressTwo post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractParser
 */
class AddressOne extends AbstractParser
{
	/**
	 * {@inheritdoc}
	 */
	protected $_validTransactionCodes = array('27');

	const STATE_ADDRESS_ONE_POST_PARSED		= 'First address post parsed';

	/**
	 * {@inheritdoc}
	 */
	public function checkSyntax($rowData)
	{
		$regex = "/^[\s\p{L}0-9.]{35}[\s\p{L}0-9.]{9}[\s]{34}[\r]{0,1}[\n]{1}$/";
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

			// Get name;
			$start = 0;
			$length = 35;
			$returnObject->setAddress(rtrim(substr($rowData, $start, $length)));
			// Get extra name;
			$start = 0;
			$length = 9;
			$returnObject->setZipCode(rtrim(substr($rowData, $start, $length)));
			// The rest is empty, so it is no need to save that.
			$this->_state = self::STATE_ADDRESS_ONE_POST_PARSED;
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
		if (!$this->_objectType instanceof Object\ObjectInterface)
		{
			return $this->_objectType = new Object\AddressOne($data);
		}
		else
		{
			return $this->_objectType->setData($data);
		}
	}
}
