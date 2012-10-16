<?php
/**
 * An object defines the data that is transferred between a
 * BGI\Row\Parser.ParserInterface and an
 * BGI\InfoContainer.InfoContainerInterface.
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */

namespace BGI\Row\Object;

/**
 * An object defines the data that is transferred between a
 * BGI\Row\Parser.ParserInterface and an
 * BGI\InfoContainer.InfoContainerInterface.
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		ObjectInterface
 * @abstract
 */
abstract class AbstractObject implements ObjectInterface
{
	/**
	 * Must be string if transaction code is below 10 and will then be zero
	 * filled, otherwise it can be an int.
	 * @access	protected
	 * @var		string|int
	 */
	protected $_transactionCode;

	/**
	 * {@inheritdoc}
	 * @abstract
	 */
	public function __construct(array $data = array())
	{
		$this->setData($data);
	}

	/**
	 * {@inheritdoc}
	 * @abstract
	 */
	abstract public function setData(array $data);

	/**
	 * {@inheritdoc}
	 */
	public function getTransactionCode()
	{
		return $this->_transactionCode;
	}

	/**
	 * {@inheritdoc}
	 * @return	AbstractObject
	 */
	public function setTransactionCode($transactionCode)
	{
		$this->_transactionCode = $transactionCode;
		return $this;
	}

	/**
	 * Set single datum to a certain value. Datum can for example be
	 * transactionCode.
	 * This function should be called by concrete object setData when a datum is
	 * not specified there.
	 * @access	private
	 * @param	string $datum
	 * @param	string $value
	 */
	private function setDatum($datum, $value)
	{
			switch ($datum)
			{
				case 'transactionCode':
					$this->setTransactionCode($value);
				default:
					break;
			}
	}
}
