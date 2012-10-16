<?php
/**
 * Name object interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Object;

/**
 * End object interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
interface NameInterface
{
	/**
	 * Get name.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	string
	 */
	public function getName();

	/**
	 * Get extra name.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	string
	 */
	public function getExtraName();

	/**
	 * Sets name.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	string
	 */
	public function setName($name);

	/**
	 * Sets extra name.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	string
	 */
	public function setExtraName($extraName);
}
