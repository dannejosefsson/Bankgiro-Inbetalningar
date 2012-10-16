<?php
/**
 * This file includes the ParserInterface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Parser;

use BGI\Row\Object\ObjectInterface;

/**
 * This file includes the ParserInterface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
interface ParserInterface
{
	/**
	 * Make sure that the row data follows the syntax given by the
	 * specification.
	 * Note that the transaction code should not be in the row data.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param string $rowData
	 */
	public function checkSyntax($rowData);

	/**
	 * Parse the row data into a row object and return false if fails.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	string $transactionCode
	 * @param	string $rowData
	 * @return	boolean
	 */
	public function parseRow($transactionCode, $rowData);

	/**
	 * Factory method to set the return type of parseRowData
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param ObjectInterface $rowObject
	 */
	public	function setObjectType(ObjectInterface $rowObject = null);

	/**
	 * Returns the object
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	string
	 */
	public	function getObjectType();

	/**
	 * Returns the object state
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	string
	 */
	public function getState();
}
