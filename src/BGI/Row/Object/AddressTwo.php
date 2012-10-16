<?php
/**
 * AddressTwo object.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractObject
 * @uses		TransactionInterface
 */
namespace BGI\Row\Object;

/**
 * AddressTwo object.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractObject
 * @uses		AddressTwoInterface
 */
class AddressTwo extends AbstractObject implements AddressTwoInterface
{
	/**#@+ @access protected */
	/**
	 * City.
	 * @var string
	 */
	protected $_city;

	/**
	 * Country.
	 * @var string
	 */
	protected $_country;

	/**
	 * Country code.
	 * @var string
	 */
	protected $_countryCode;
	/**#@- */

	/**
	 * {@inheritdoc}
	 * @return	AddressTwo
	 */
	public function setData(array $data)
	{
		foreach ($data as $key => $value)
		{
			switch ($key)
			{
				case 'city':
					$this->setCity($value);
					break;
				case 'country':
					$this->setCountry($value);
					break;
				case 'countryCode':
					$this->setCountryCode($value);
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
	public function getCity()
	{
		return $this->_;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCountry()
	{
		return $this->_country;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCountryCode()
	{
		return $this->_countryCode;
	}

	/**
	 * {@inheritdoc}
	 * @return	AddressTwo
	 */
	public function setCity($city)
	{
		$this->_city = $city;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return	AddressTwo
	 */
	public function setCountry($country)
	{
		$this->_country = $country;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return	AddressTwo
	 */
	public function setCountryCode($countryCode)
	{
		$this->_countryCode = $countryCode;
		return $this;
	}

}
