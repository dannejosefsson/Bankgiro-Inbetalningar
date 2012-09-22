<?php
namespace BGI\Row\Object;

abstract class AbstractObject implements ObjectInterface
{
	/**
	 * (non-PHPdoc)
	 * @see		BGI\Row\Object.ObjectInterface::__construct(array $data)
	 * @param	array $data
	 */
	abstract public function __construct(array $data);
	/**
	 * (non-PHPdoc)
	 * @see BGI\Row\Object.ObjectInterface::setData()
	 */
	abstract public function setData(array $data);
}
