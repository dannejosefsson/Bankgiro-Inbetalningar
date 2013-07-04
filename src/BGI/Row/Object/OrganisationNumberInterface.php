<?php
/**
 * Organisation number object interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Object;

/**
 * Organisation number object interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
interface OrganisationNumberInterface
{
	/**
	 * Transaction code
	 * @var string
	 */
	const TRANSACTION_CODE = '29';

	/**
	 * Get organisation number.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int|string
	 */
	public function getOrganisationNumber();

	/**
	 * Sets organisation number.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int|string
	 */
	public function setOrganisationNumber($organisationNumber);
}
