<?php
/**
 * Visitor Interface of the BGI system.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */

namespace BGI\Visitor;

use BGI\InfoContainer\InfoContainerInterface;
use BGI\Row\Object\ObjectInterface;
use BGI\Row\Parser\ParserInterface;


interface VisitorInterface {

	/**
	 * Visits an info container.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param InfoContainerInterface $infoContainer
	 */
	public function visitInfoContainer(InfoContainerInterface $infoContainer);

	/**
	 * Visits an object.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param ObjectInterface $object
	 */
	public function visitObject(ObjectInterface $object);

	/**
	 * Visits a parser.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param ParserInterface $parser
	 */
	public function visitParser(ParserInterface $parser);

	/**
	 * Get the result of the visits.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return mixed.
	 */
	public function getResult();
}