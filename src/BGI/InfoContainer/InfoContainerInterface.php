<?php
/**
 * The interface for an info container.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\InfoContainer;

use BGI\Row\Object\ObjectInterface;
use BGI\Row\Parser\ParserInterface;

/**
 * The interface for an info container.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
interface InfoContainerInterface
{
	/**
	 * Returns the transaction code of the info container starting row.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @static
	 * @return	int|string
	 */
	public static function getStartTransactionCode();

	/**
	 * Set a row parser for a specific transaction code.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	string|int $transactionCode
	 * @param	ParserInterface $rowParserObject
	 */
	public function setRowParser(	$transactionCode,
									ParserInterface $rowParserObject);

	/**
	 * Parse a row. The transaction code must have a parser connected to it.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int|string $transactionCode
	 * @param	string $rowData
	 */
	public function parseRow($transactionCode, $rowData);

	/**
	 * Returns the state.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	string $option
	 * @return	string
	 */
	public function getState($option = null);

	/**
	 * Set a specific error. Also sets the state to error.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	string $errorMsg
	 */
	public function setError($errorMsg);

	/**
	 * Returns all errors of the info container.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	array
	 */
	public function getErrors();

	/**
	 * Returns its and all lower level info container errors.
	 * @author Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return array
	 */
	public function getErrorsRecursevly();

	/**
	 * Set lower lever info container so the next stage can be handeled.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param InfoContainerInterface $infoContainerInterfaceType
	 */
	public function setLowerLevelInfoContainerType(
						InfoContainerInterface $infoContainerInterfaceType);

	/**
	 * Take care of an object returned from a parser.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param ObjectInterface $object
	 */
	public function handleObject(ObjectInterface $object);

	/**
	 * Check if the given transaction code is the start post of the stage.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @static
	 * @param string $transactionCode
	 */
	public static function isStartPost($transactionCode);
}
