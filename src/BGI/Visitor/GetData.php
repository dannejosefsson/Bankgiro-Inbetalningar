<?php
/**
 * Gets data from InfoContainers and Objects
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Visitor;

use BGI\Visitor\AbstractVisitor;
use BGI\Row\Parser\ParserInterface;
use BGI\Row\Object\ObjectInterface;
use BGI\InfoContainer\InfoContainerInterface;

class GetData extends AbstractVisitor {

	protected $_dataArray = array();

	/**
	 * {@inheritdoc}
	 */
	public function visitInfoContainer(InfoContainerInterface $infoContainer) {
		$this->_dataArray[] = $infoContainer->getStartTransactionCode();
	}

	/**
	 * {@inheritdoc}
	 */
	public function visitObject(ObjectInterface $object) {

	}

	/**
	 * {@inheritdoc}
	 */
	public function visitParser(ParserInterface $parser) {

	}

	/**
	 * {@inheritdoc}
	 * @return array of data.
	 */
	public function getResult() {
		return $this->_dataArray;
	}
}
