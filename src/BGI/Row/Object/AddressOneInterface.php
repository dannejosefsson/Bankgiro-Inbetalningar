<?php
/**
 * Address one object interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Object;

/**
 * Address one object interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
interface AddressOneInterface
{
	/**
	 * Transaction code
	 * @var string
	 */
	const TRANSACTION_CODE = '27';

	/**
	 * Get the address.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	string
	 */
	public function getAddress();

	/**
	 * Get the zip code.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int|string
	 */
	public function getZipCode();

	/**
	 * Sets the zip address.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	string $address
	 */
	public function setAddress($address);

	/**
	 * Sets the address.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	string $zipCode
	 */
	public function setZipCode($zipCode);
}
