<?php
/**
 * End object.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Object;

/**
 * End object.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractObject
 * @uses		EndInterface
 */
class End extends AbstractObject implements EndInterface
{
	/**#@+ @access protected */
	/**
	 * Payment post count.
	 * @var int
	 */
	protected $_paymentPostsCount;

	/**
	 * Deduction post count.
	 * @var int
	 */
	protected $_deductionPostsCount;

	/**
	 * Extra reference posts count.
	 * @var int
	 */
	protected $_extraReferencePostsCount;

	/**
	 * Deposit posts count.
	 * @var int
	 */
	protected $_depositPostsCount;
	/**#@- */

	/**
	 * {@inheritdoc}
	 * @return	End
	 */
	public function setData(array $data)
	{
		foreach ($data as $key => $value)
		{
			switch ($key)
			{
				case 'paymentPostsCount':
					$this->setPaymentPostsCount($value);
					break;
				case 'deductionPostsCount':
					$this->setDeductionPostsCount($value);
					break;
				case 'extraReferencePostsCount':
					$this->setExtraReferencePostsCount($value);
					break;
				case 'depositPostsCount':
					$this->setDepositPostsCount($value);
					break;
				default:
					parent::setDatum($key, $value);
					break;
			}
		}
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPaymentPostsCount()
	{
		return $this->_paymentPostsCount;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDeductionPostsCount()
	{
		return $this->_deductionPostsCount;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getExtraReferencePostsCount()
	{
		return $this->_extraReferencePostsCount;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDepositPostsCount()
	{
		return $this->_depositPostsCount;
	}

	/**
	 * {@inheritdoc}
	 * @return	End
	 */
	public function setPaymentPostsCount($paymentPostsCount)
	{
		$this->_paymentPostsCount = $paymentPostsCount;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return	End
	 */
	public function setDeductionPostsCount($deductionPostsCount)
	{
		$this->_deductionPostsCount = $deductionPostsCount;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return	End
	 */
	public function setExtraReferencePostsCount($extraReferencePostsCount)
	{
		$this->_extraReferencePostsCount = $extraReferencePostsCount;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return	End
	 */
	public function setDepositPostsCount($depositPostsCount)
	{
		$this->_depositPostsCount = $depositPostsCount;
		return $this;
	}
}
