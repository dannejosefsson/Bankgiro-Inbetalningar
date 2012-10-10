<?php
namespace BGI\Row\Object;

/**
 * An object defines the data that is transferred between a
 * BGI\Row\Parser.ParserInterface and an
 * BGI\InfoContainer.InfoContainerInterface.
 * @author Daniel Josefsson <dannejosefsson@gmail.com>
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
	 * (non-PHPdoc)
	 * @see		BGI\Row\Object.ObjectInterface::__construct(array $data)
	 * @param	array $data
	 */
	public function __construct(array $data = array())
	{
		$this->setData($data);
	}

	/**
	 * (non-PHPdoc)
	 * @see BGI\Row\Object.ObjectInterface::setData()
	 */
	abstract public function setData(array $data);

	/**
	 * (non-PHPdoc)
	 * @see BGI\Row\Object.ObjectInterface::getTransactionCode()
	 * @return string|int
	 */
	public function getTransactionCode()
	{
		return $this->_transactionCode;
	}

	/**
	 * (non-PHPdoc)
	 * @see BGI\Row\Object.ObjectInterface::setTransactionCode()
	 * @return AbstractObject
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
	 * @param string $datum
	 * @param string $value
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
