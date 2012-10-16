<?php
/**
 * Address two object interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Object;

/**
 * Address two object interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
interface AddressTwoInterface
{
	/**
	 * Get city.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	string
	 */
	public function getCity();

	/**
	 * Get Country.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	string
	 */
	public function getCountry();

	/**
	 * Get country code.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	string
	 */
	public function getCountryCode();

	/**
	 * Sets city.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	string
	 */
	public function setCity($city);

	/**
	 * Sets country.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	string
	 */
	public function setCountry($country);

	/**
	 * Sets country code.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	string
	 */
	public function setCountryCode($countryCode);
}
