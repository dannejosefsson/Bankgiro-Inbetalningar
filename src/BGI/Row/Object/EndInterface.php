<?php
/**
 * End object interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Object;

/**
 * End object interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
interface EndInterface
{
	/**
	 * Get payment posts count.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int
	 */
	public function getPaymentPostsCount();

	/**
	 * Get deduction posts count.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int
	 */
	public function getDeductionPostsCount();

	/**
	 * Get extra reference posts count.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int
	 */
	public function getExtraReferencePostsCount();

	/**
	 * Get deposit posts count.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int
	 */
	public function getDepositPostsCount();

	/**
	 * Sets payment posts count.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int
	 */
	public function setPaymentPostsCount($paymentPostsCount);

	/**
	 * Sets deduction posts count.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int
	 */
	public function setDeductionPostsCount($deductionPostsCount);

	/**
	 * Sets extra reference posts count.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int
	 */
	public function setExtraReferencePostsCount($extraReferencePostsCount);

	/**
	 * Sets deposit posts count.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int
	 */
	public function setDepositPostsCount($depositPostsCount);
}
