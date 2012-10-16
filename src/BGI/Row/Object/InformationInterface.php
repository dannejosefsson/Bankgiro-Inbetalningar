<?php
/**
 * Information object interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Object;

/**
 * Information object interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
interface InformationInterface
{
	/**
	 * Returns the information.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	string
	 */
	public function getInformation();

	/**
	 * Set the information
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param string $information
	 */
	public function setInformation($information);
}
