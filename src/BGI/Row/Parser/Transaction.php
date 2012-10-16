<?php
/**
 * Transaction post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Parser;

use BGI\Row\Object as Object;

/**
 * Transaction post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractParser
 */
class Transaction extends AbstractParser
{
	/**
	 * {@inheritdoc}
	 */
	protected $_validTransactionCodes = array('20', '21', '22', '23');

	const STATE_TRANSACTION_POST_PARSED		= 'Transaction post parsed';

	/**
	 * {@inheritdoc}
	 */
	public function checkSyntax($rowData)
	{
		//TODO: Coma given in second part is not given in the technical manual, but given in test files. Check with BGC
		$regex = "/^[0-9]{10}[\p{L}\s,0-9]{25}[0-9]{18}[0-9]{1}[0-9]{1};
		$regex .= [0-9\p{L}]{12}[0-9\s]{1}[0-9\s]{1}[\s]{9}/u";
		return (preg_match($regex, $rowData))? true: false;
	}

	/**
	 * {@inheritdoc}
	 * @uses	checkSyntax($rowData)
	 */
	public function parseRow($transactionCode, $rowData)
	{
		if ($this->checkSyntax($rowData))
		{
			$data = array();
			$returnObject = $this->getObject($data);
			$returnObject->setTransactionCode($transactionCode);
			// Get sender bankgiro.
			$start = 0;
			$length = 10;
			$returnObject->setSenderBankgiro(
				(int) substr($rowData, $start, $length));
			// Get reference numbers
			$start = $start + $length;
			$length = 25;
			$returnObject->setReferences(
				//TODO: Comma given is not given in the technical manual, but given in test files. Check with BGC
				preg_split(	"@[ ,]@", substr($rowData, $start, $length),
							NULL, PREG_SPLIT_NO_EMPTY));
			// Get payment value
			$start = $start + $length;
			$length = 18;
			$returnObject->setPaymentValue((int) substr($rowData,
														$start, $length));
			// Get reference code
			$start = $start + $length;
			$length = 1;
			$returnObject->setReferenceCode((int) substr(	$rowData,
															$start, $length));
			// Get payment channel.
			$start = $start + $length;
			$length = 1;
			$returnObject->setPaymentChannel((int) substr(	$rowData,
															$start, $length));
			// Get BGC reference number.
			$start = $start + $length;
			$length = 12;
			$returnObject->setBgcReferenceNumber(substr(	$rowData,
															$start, $length));
			// Get depicture marker.
			$start = $start + $length;
			$length = 1;
			$returnObject->setDepictureMarker((int) substr(	$rowData,
															$start, $length));
			// Get deduction code.
			$start = $start + $length;
			$length = 1;
			$returnObject->setDeductionCode(substr($rowData, $start, $length));
			// The rest is empty, so it is no need to save that.
			$this->_state = self::STATE_TRANSACTION_POST_PARSED;
			return $returnObject;
		}
		else
		{
			return false;
		}
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getObject(array $data)
	{
		if (	!$this->_objectType instanceof Object\ObjectInterface &&
				!$this->_objectType instanceof Object\SummationInterface)
		{
			return $this->_objectType = new Object\Transaction();
		}
		else
		{
			return $this->_objectType->setData($data);
		}
	}
}
