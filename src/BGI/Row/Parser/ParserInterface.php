<?php
namespace BGI\Row\Parser;

interface ParserInterface
{
	/**
	 * Make sure that the row data follows the syntax given by the specification.
	 * Note that the transaction code should not be in the row data.
	 * @param string $rowData
	 */
	public function checkSyntax($rowData);
	/**
	 * Parse the row data into a row object and return false if fails.
	 * @param string $rowData
	 */
	public function parseRowData($rowData);
}
