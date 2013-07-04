<?php
/**
 * Info container factory.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\InfoContainer;

/**
 * Info container factory.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
class InfoContainerFactory
{
	/**
	 * Get a file info container.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	File
	 */
	static public function getFile()
	{
		return new File();
	}

	/**
	 * Get a deposit info container.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	Deposit
	 */
	public function getDeposit()
	{
		return new Deposit();
	}

	/**
	 * Get a transaction info container.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	Transaction
	 */
	public function getTransaction()
	{
		return new Transaction();
	}
}