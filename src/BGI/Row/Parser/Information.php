<?php
/**
 * Information post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Parser;

use BGI\Row\Object as Object;

/**
 * Information post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractParser
 */
class Information extends AbstractParser
{
	/**
	 * {@inheritdoc}
	 */
	protected $_validTransactionCodes = array('25');

	const STATE_INFORMATION_POST_PARSED		= 'Information post parsed';

	/**
	 * @see BGI\Row\Parser.AbstractParser::checkSyntax()
	 */
	/**
	 * {@inheritdoc}
	 */
	public function checkSyntax($rowData)
	{
		$regex = "/^[0-9\s\p{L}]{50}[\s]{28}$/";
		return (preg_match($regex, $rowData))? true: false;
	}

	/**
	 * {@inheritdoc}
	 * @uses	checkSyntax($rowData)
	 */
	public function parseRow($transactionCode, $rowData)
	{
		if ($this->checkTransactionCode($transactionCode) && $this->checkSyntax($rowData))
		{
			$data = array();
			$returnObject = $this->getObject($data);
			$returnObject->setTransactionCode($transactionCode);

			// Get information
			$start = 0;
			$length = 50;
			$returnObject = $this->getObject($data);
			$returnObject->setInformation(rtrim(substr($rowData, $start, $length)));
			// The rest is empty, so it is no need to save that.
			$this->_state = self::STATE_INFORMATION_POST_PARSED;
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
		if (!$this->_objectType instanceof Object\ObjectInterface)
		{
			return $this->_objectType = new Object\Information($data);
		}
		else
		{
			return $this->_objectType->setData($data);
		}
	}
}
