<?php
/**
 * Abstract visitor of the BGI system.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Visitor;

use BGI\Row\Parser\ParserInterface;
use BGI\Row\Object\ObjectInterface;
use BGI\InfoContainer\InfoContainerInterface;

/**
 * Implements the associated interface.
 * @author Daniel Josefsson <dannejosefsson@gmail.com>
 */
abstract class AbstractVisitor implements VisitorInterface {

	/**
	 * {@inheritdoc}
	 * @abstract
	 */
	abstract public function visitInfoContainer(InfoContainerInterface $infoContainer);

	/**
	 * {@inheritdoc}
	 * @abstract
	 */
	abstract public function visitObject(ObjectInterface $object);

	/**
	 * {@inheritdoc}
	 * @abstract
	 */
	abstract public function visitParser(ParserInterface $parser);

	/**
	 * {@inheritdoc}
	 * @abstract
	 */
	abstract public function getResult();
}
