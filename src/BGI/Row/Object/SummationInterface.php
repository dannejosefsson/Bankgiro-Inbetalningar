<?php
/**
 * Summation object interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Object;

/**
 * Summation object interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
interface SummationInterface
{
	/**
	 * Get receiver bank account number.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int|string
	 */
	public function getReceiverBankAccountNumber();

	/**
	 * Get deposit date.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int|string
	 */
	public function getDepositDate();

	/**
	 * Get deposit number.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int
	 */
	public function getDepositNumber();

	/**
	 * Get deposit value.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int
	 */
	public function getDepositValue();

	/**
	 * Get currency.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	string
	 */
	public function getCurrency();

	/**
	 * Get transactions count.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int
	 */
	public function getTransactionsCount();

	/**
	 * Get deposit type.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int|string
	 */
	public function getDepositType();

	/**
	 * Sets receiver bank account number.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int|string
	 */
	public function setReceiverBankAccountNumber($bankAccountNumber);

	/**
	 * Sets deposit date.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int|string
	 */
	public function setDepositDate($depositDate);

	/**
	 * Sets deposit number.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int
	 */
	public function setDepositNumber($depositNumber);

	/**
	 * Sets deposit value.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int
	 */
	public function setDepositValue($depositValue);

	/**
	 * Sets currency.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	string
	 */
	public function setCurrency($currency);

	/**
	 * Sets transactions count.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int
	 */
	public function setTransactionsCount($transactionCount);

	/**
	 * Sets deposit type.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int|string
	 */
	public function setDepositType($depositType);
}
