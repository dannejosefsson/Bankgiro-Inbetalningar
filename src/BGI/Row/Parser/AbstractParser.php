<?php
namespace BGI\Row\Parser;

use BGI\Row\Object\ObjectInterface;

abstract class AbstractParser implements ParserInterface
{
	/**
	 * @access	protected
	 * @var		ObjectInterface
	 */
	protected $_objectType = null;

	/**
	 * (non-PHPdoc)
	 * @see BGI\Row\Parser.ParserInterface::checkSyntax()
	 */
	abstract public		function checkSyntax($rowData);

	/**
	 * (non-PHPdoc)
	 * @see BGI\Row\Parser.ParserInterface::parseRowData()
	 */
	abstract public		function parseRowData($rowData);

	/**
	 * Factory method to set the return type of parseRowData
	 * @param ObjectInterface $rowObject
	 */
	abstract public		function setObjectType(ObjectInterface $rowObject = null);

	/**
	 * @param array $data
	 */
	abstract protected	function getObject(array $data);
}
