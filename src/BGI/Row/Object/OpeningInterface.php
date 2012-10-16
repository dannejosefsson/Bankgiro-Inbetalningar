<?php
/**
 * Name object interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Object;

/**
 * Name object interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
interface OpeningInterface
{
	/**
	 * Get bankgiro.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int|string
	 */
	public function getBankgiro();

	/**
	 * Get plusgiro.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int|string
	 */
	public function getPlusgiro();

	/**
	 * Get currency.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	string
	 */
	public function getCurrency();

	/**
	 * Sets plusgiro.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int|string
	 */
	public function setBankgiro($bankgiro);

	/**
	 * Sets bankgiro.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int|string
	 */
	public function setPlusgiro($plusgiro);

	/**
	 * Sets currency.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	string
	 */
	public function setCurrency($currency);
}
