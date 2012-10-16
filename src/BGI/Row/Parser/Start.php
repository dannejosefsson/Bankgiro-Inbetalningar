<?php
/**
 * Transaction post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Parser;

use BGI\Row\Object as Object;

/**
 * Transaction post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractParser
 */
class Start extends AbstractParser
{
	/**
	 * {@inheritdoc}
	 */
	protected $_validTransactionCodes = array('01');

	const STATE_START_POST_PARSED		= 'Start post parsed';

	/**
	 * {@inheritdoc}
	 */
	public function checkSyntax($rowData)
	{
		$regex = "/^[\s\w]{20}[0-9]{2}[0-9]{20}[PT]{1}[\s]{35}$/";
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
			$length = 20;
			$data['layout'] = rtrim(substr($rowData, $start, $length));
			// Get version
			$start = $start + $length;
			$length = 2;
			$data['version'] = substr($rowData, $start, $length);
			// Get datetime
			$start = $start + $length;
			$lengthDate = 8;
			$startTime = $start + $lengthDate;
			$lengthTime = 6;
			$data['date'] = date(	'Y-m-d H:i:s',
									strtotime(	substr($rowData, $start,
													$lengthDate).
												'T'.
												substr($rowData, $startTime,
													$lengthTime)));
			// Get micro seconds
			$start = $startTime + $lengthTime;
			unset($lengthDate, $startTime, $lengthTime);
			$length = 6;
			$data['microSeconds'] = (int) substr($rowData, $start, $length);
			// Get file marker
			$start = $start + $length;
			$length = 1;
			$data['fileMarker'] = substr($rowData, $start, $length);
			// The rest is empty, so it is no need to save that.
			$this->_state = self::STATE_START_POST_PARSED;
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
			return $this->_objectType = new Object\Start($data);
		}
		else
		{
			return $this->_objectType->setData($data);
		}
	}
}
