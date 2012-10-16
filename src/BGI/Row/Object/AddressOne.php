<?php
/**
 * AddressOne object.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Object;

/**
 * AddressOne object.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractObject
 * @uses		AddressOneInterface
 */
class AddressOne extends AbstractObject implements AddressOneInterface
{
	/**#@+ @access protected */
	/**
	 * Address.
	 * @var string
	 */
	protected $_address;
	/**
	 * Zip code.
	 * @var int|string
	 */
	protected $_zipCode;
	/**#@- */

	/**
	 * {@inheritdoc}
	 * @return	AddressOne
	 */
	public function setData(array $data)
	{
		foreach ($data as $key => $value)
		{
			switch ($key)
			{
				case 'address':
					$this->setAddress($value);
					break;
				case 'zipCode':
					$this->setZipCode($value);
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
	public function getAddress()
	{
		return $this->_address;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getZipCode()
	{
		return $this->_zipCode;
	}

	/**
	 * {@inheritdoc}
	 * @return	AddressOne
	 */
	public function setAddress($address)
	{
		$this->_address = $address;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return	AddressOne
	 */
	public function setZipCode($zipCode)
	{
		$this->_zipCode = $zipCode;
		return $this;
	}
}
