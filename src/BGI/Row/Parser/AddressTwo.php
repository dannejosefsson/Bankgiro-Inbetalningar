<?php
/**
 * AddressTwo post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Parser;

use BGI\Row\Object as Object;

/**
 * AddressTwo post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractParser
 */
class AddressTwo extends AbstractParser
{
	/**
	 * {@inheritdoc}
	 */
	protected $_validTransactionCodes =
		array(Object\AddressTwoInterface::TRANSACTION_CODE);

	const STATE_ADDRESS_TWO_POST_PARSED		= 'Second address post parsed';

	/**
	 * {@inheritdoc}
	 */
	public function checkSyntax($rowData)
	{
		$regex = "/^[\s\p{L}0-9]{35}[\s\p{L}0-9]{35}[\s\p{L}0-9]{2}[\s]{6}[\r]{0,1}[\n]{1}$/";
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

			// Get city.
			$start = 0;
			$length = 35;
			$returnObject->setCity(rtrim(substr($rowData, $start, $length)));
			// Get country.
			$start = $start + $length;
			$length = 35;
			$returnObject->setCountry(rtrim(substr($rowData, $start, $length)));
			// Get country code.
			$start = $start + $length;
			$length = 2;
			$returnObject->setCountryCode(
				rtrim(substr($rowData, $start, $length)));
			// The rest is empty, so it is no need to save that.
			$this->_state = self::STATE_ADDRESS_TWO_POST_PARSED;
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
			return $this->_objectType = new Object\AddressTwo($data);
		}
		else
		{
			return $this->_objectType->setData($data);
		}
	}
}
