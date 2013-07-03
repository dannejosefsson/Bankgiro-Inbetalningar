<?php
/**
 * Organisation number post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractParser
 */
namespace BGI\Row\Parser;

use BGI\Row\Object as Object;

/**
 * Organisation number post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractParser
 */
class OrganisationNumber extends AbstractParser
{
	/**
	 * {@inheritdoc}
	 */
	protected $_validTransactionCodes = array('29');

	const STATE_ORGANISATION_NUMBER_POST_PARSED		= 'Organisation number post parsed';

	/**
	 * {@inheritdoc}
	 */
	public function checkSyntax($rowData)
	{
		$regex = "/^[0-9]{12}[\s]{66}[\r]{0,1}[\n]{1}$/";
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

			// Get organisation number.
			$start = 0;
			$length = 12;
			$returnObject = $this->getObject($data);
			$returnObject->setOrganisationNumber(
				(int) substr($rowData, $start, $length));
			// The rest is empty, so it is no need to save that.
			$this->_state = self::STATE_ORGANISATION_NUMBER_POST_PARSED;
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
			return $this->_objectType = new Object\OrganisationNumber($data);
		}
		else
		{
			return $this->_objectType->setData($data);
		}
	}
}
