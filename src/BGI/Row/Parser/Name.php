<?php
/**
 * Name post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Parser;

use BGI\Row\Object as Object;

/**
 * Name post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractParser
 */
class Name extends AbstractParser
{
	/**
	 * {@inheritdoc}
	 */
	protected $_validTransactionCodes =
		array(Object\NameInterface::TRANSACTION_CODE);

	const STATE_NAME_POST_PARSED		= 'Name post parsed';

	/**
	 * {@inheritdoc}
	 */
	public function checkSyntax($rowData)
	{
		$regex = "/^[\s\p{L},]{35}[\s\p{L},]{35}[\s]{8}[\r]{0,1}[\n]{1}$/";
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

			// Get name;
			$start = 0;
			$length = 35;
			$returnObject->setName(rtrim(substr($rowData, $start, $length)));
			// Get extra name;
			$start = 0;
			$length = 35;
			$returnObject->setExtraName(rtrim(
				substr($rowData, $start, $length)));
			// The rest is empty, so it is no need to save that.
			$this->_state = self::STATE_NAME_POST_PARSED;
			$object = $this->getObject($data);
			$object->setTransactionCode($transactionCode);
			return $object;
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
			return $this->_objectType = new Object\Name($data);
		}
		else
		{
			return $this->_objectType->setData($data);
		}
	}
}
