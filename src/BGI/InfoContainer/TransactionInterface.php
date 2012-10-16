<?php
/**
 * Transaction interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\InfoContainer;

/**
 * Transaction interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
interface TransactionInterface
{
	/**
	 * Get transactions count.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int
	 */
	public function getTransactionsCount();

	/**
	 * Returns the payment value. Can be both positive and negative
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int
	 */
	public function getPaymentValue();

	/**
	 * Counts the number of parsed extra references.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int
	 */
	public function countExtraReferences();

	/**
	 * Returns the transaction code.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int|string
	 */
	public function getTransactionCode();
}
