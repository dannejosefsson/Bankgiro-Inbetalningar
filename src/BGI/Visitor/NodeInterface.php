<?php

/**
 * Node interface to the visior pattern.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Visitor;

use BGI\Visitor\VisitorInterface;

interface NodeInterface {

	/**
	 * Function to call to visit the info container.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param VisitInfoContainerInterface $visitor
	 */
	public function accept(VisitorInterface $visitor);
}
