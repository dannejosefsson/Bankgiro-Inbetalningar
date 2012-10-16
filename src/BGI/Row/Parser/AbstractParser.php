<?php
/**
 * This file contains the AbstractParser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Parser;

use BGI\Row\Object as Object;

/**
 * This file contains the AbstractParser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @abstract
 * @uses		ParserInterface
 */
abstract class AbstractParser implements ParserInterface
{
	/**#@+ @access protected */

	/**
	 * Valid transaction codes.
	 * $var array valid transaction codes.
	 */
	protected $_validTransactionCodes = array();

	/**
	 * Instance of an ObjectInterface.
	 * @var		Object\ObjectInterface
	 */
	protected $_objectType = null;

	/**
	 * Current state.
	 * @var string
	 */
	protected $_state = self::STATE_IDLE;
	/**#@- */

	const STATE_IDLE	= 'Idle';
	const STATE_ERROR	= 'Error occured';

	/**
	 * {@inheritdoc}
	 * @abstract
	 */
	abstract public function checkSyntax($rowData);

	/**
	 * {@inheritdoc}
	 * @abstract
	 */
	abstract public function parseRow($transactionCode, $rowData);

	/**
	 * {@inheritdoc}
	 * @return	AbstractParser
	 */
	public function setObjectType(Object\ObjectInterface $rowObject = null)
	{
		$this->_objectType = $rowObject;
		return $this;
	}

	/**
	 * Returns the object and sets it with data. Is a factory method; silently
	 * gets an object, if neccessary.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	array $data
	 * @abstract
	 * @return	Object\ObjectInterface
	 */
	abstract protected function getObject(array $data = array());

	/**
	 * {@inheritdoc}
	 */
	public	function getObjectType()
	{
		return $this->_objectType;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getState()
	{
		return $this->_state;
	}

	/**
	 * Checks so the transaction code is an valid one for this parser.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	string $transactionCode
	 * @uses	AbstractParser::$_validTransactionCodes
	 * @throws	ParserException
	 * @return	boolean
	 */
	protected function checkTransactionCode($transactionCode)
	{
		if (!is_array($this->_validTransactionCodes))
			throw new
				ParserException('$_validTransactioncodes must be an array.');

		if (empty($this->_validTransactionCodes))
			throw new ParserException('$_validTransactioncodes must values.');

		if (!in_array($transactionCode, $this->_validTransactionCodes))
		{
			$validTransactionCodes =
				'Valid transaction codes: ' .
				implode(', ', $this->_validTransactionCodes).
				'. '. $transactionCode . ' given.';
			throw new ParserException( $validTransactionCodes);
		}

		return true;
	}
}
