<?php
/**
 * Opening object.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Object;

/**
 * Opening object.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractObject
 * @uses		OpeningInterface
 */
class Opening extends AbstractObject implements OpeningInterface
{
	/**#@+ @access protected */
	/**
	 * Bankgiro.
	 * @var int|string
	 */
	protected $_bankgiro;

	/**
	 * Plusgiro.
	 * @var int|string
	 */
	protected $_plusgiro;

	/**
	 * Currency.
	 * @var string
	 */
	protected $_currency;
	/**#@- */

	/**
	 * {@inheritdoc}
	 * @return Opening
	 */
	public function setData(array $data)
	{
		foreach ($data as $key => $value)
		{
			switch ($key)
			{
				case 'bankgiro':
					$this->setBankgiro($value);
					break;
				case 'plusgiro':
					$this->setPlusgiro($value);
					break;
				case 'currency':
					$this->setCurrency($value);
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
	public function getBankgiro()
	{
		return $this->_bankgiro;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPlusgiro()
	{
		return $this->_plusgiro;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCurrency()
	{
		return $this->_currency;
	}

	/**
	 * {@inheritdoc}
	 * @return Opening
	 */
	public function setBankgiro($bankgiro)
	{
		$this->_bankgiro = $bankgiro;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return Opening
	 */
	public function setPlusgiro($plusgiro)
	{
		$this->_plusgiro = $plusgiro;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return Opening
	 */
	public function setCurrency($currency)
	{
		$this->_currency = $currency;
		return $this;
	}
}
