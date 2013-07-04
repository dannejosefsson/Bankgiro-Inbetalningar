<?php
/**
 * Transaction object interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Object;

/**
 * Transaction object interface.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
interface TransactionInterface
{
	/**
	 * Transaction code for transaction.
	 * @var string
	 */
	const TRANSACTION_CODE_TR = '20';

	/**
	 * Transaction code for deduction.
	 * @var string
	 */
	const TRANSACTION_CODE_DE = '21';

	/**
	 * Transaction code for transaction extra reference.
	 * @var string
	 */
	const TRANSACTION_CODE_TR_ER = '22';

	/**
	 * Transaction code for deduction extra reference.
	 * @var string
	 */
	const TRANSACTION_CODE_DE_ER = '23';

	/**
	 * Get sender bankgiro.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int|string
	 */
	public function getSenderBankgiro();

	/**
	 * Get referneces.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	array
	 */
	public function getReferences();

	/**
	 * Get payment value.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int|string
	 */
	public function getPaymentValue();

	/**
	 * Get reference code.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int
	 */
	public function getReferenceCode();

	/**
	 * Get get papment channel.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int|string
	 */
	public function getPaymentChannel();

	/**
	 * Get BCG refernece number.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int|string
	 */
	public function getBgcReferenceNumber();

	/**
	 * Get depicture marker.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int|string
	 */
	public function getDepictureMarker();

	/**
	 * Get deduction code.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @return	int|string
	 */
	public function getDeductionCode();

	/**
	 * Sets sender bankgiro.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int|string
	 */
	public function setSenderBankgiro($senderBankgiro);

	/**
	 * Sets references.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	array $references
	 */
	public function setReferences(array $references);

	/**
	 * Sets payment value.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int
	 */
	public function setPaymentValue($value);

	/**
	 * Sets reference code.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int|string
	 */
	public function setReferenceCode($referenceCode);

	/**
	 * Sets payment channel.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int|string
	 */
	public function setPaymentChannel($paymentChannel);

	/**
	 * Sets BGC reference number.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int|string
	 */
	public function setBgcReferenceNumber($referenceNumber);

	/**
	 * Sets depciture marke.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int|string
	 */
	public function setDepictureMarker($depictureMarker);

	/**
	 * Sets deduction code.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	int|string
	 */
	public function setDeductionCode($deductionCode);
}
