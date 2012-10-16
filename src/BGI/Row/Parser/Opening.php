<?php
/**
 * Opening post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Parser;

use BGI\Row\Object as Object;

/**
 * Opening post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractParser
 */
class Opening extends AbstractParser
{
	/**
	 * {@inheritdoc}
	 */
	protected $_validTransactionCodes = array('05');

	const STATE_OPENING_POST_PARSED		= 'Opening post parsed';

	/**
	 * {@inheritdoc}
	 */
	public function checkSyntax($rowData)
	{
		$regex = "/^[0-9]{10}[\s0-9]{10}[A-Z]{3}[\s]{55}$/";
		return (preg_match($regex, $rowData))? true: false;
	}

	/**
	 * {@inheritdoc}
	 * @uses	checkSyntax($rowData)
	 */
	public function parseRow($transactionCode, $rowData)
	{
		if ($this->checkTransactionCode($transactionCode) &&
			$this->checkSyntax($rowData))
		{
			$data = array();
			// Get name;
			$start = 0;
			$length = 10;
			$data['bankgiro'] = (int) substr($rowData, $start, $length);
			// Get version
			$start = $start + $length;
			$length = 10;
			$data['plusgiro'] = (int) substr($rowData, $start, $length);
			// Get datetime
			$start = $start + $length;
			$length = 3;
			$data['currency'] = substr($rowData, $start, $length);
			// The rest is empty, so it is no need to save that.
			$this->_state = self::STATE_OPENING_POST_PARSED;
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
	protected function getObject(array $data)
	{
		if (!$this->_objectType instanceof Object\ObjectInterface)
		{
			return $this->_objectType = new Object\Opening($data);
		}
		else
		{
			return $this->_objectType->setData($data);
		}
	}
}
