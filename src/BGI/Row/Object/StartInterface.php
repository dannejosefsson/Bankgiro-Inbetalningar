<?php
/**
 * Start object interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Object;

/**
 * Start object interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
interface StartInterface
{
	/**
	 * Transaction code
	 * @var string
	 */
	const TRANSACTION_CODE = '01';

	/**
	 * Get layout.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int|string
	 */
	public function getLayout();

	/**
	 * Get version.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int|string
	 */
	public function getVersion();

	/**
	 * Get date.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	string
	 */
	public function getDate();

	/**
	 * Get micro seconds.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int|string
	 */
	public function getMicroSeconds();

	/**
	 * Get file marker.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int|string
	 */
	public function getFileMarker();

	/**
	 * Sets layout.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int|string
	 */

	/**
	 * Sets layout.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int|string
	 */
	public function setLayout($layout);

	/**
	 * Sets version.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int|string
	 */
	public function setVersion($version);

	/**
	 * Sets date.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	string
	 */
	public function setDate($date);

	/**
	 * Sets micro seconds.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int|string
	 */
	public function setMicroSeconds($microSeconds);

	/**
	 * Sets file marker.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int|string
	 */
	public function setFileMarker($fileMarker);
}
