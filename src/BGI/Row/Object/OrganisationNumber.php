<?php
/**
 * Transaction object.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Object;

/**
 * Transaction object.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractObject
 * @uses		OrganisationNumberInterface
 */
class OrganisationNumber extends AbstractObject implements OrganisationNumberInterface
{
	/**
	 * Organisation number.
	 * @var int|string
	 * @access	protecteds
	 */
	protected $_organisationNumber;

	/**
	 * {@inheritdoc}
	 * @return OrganisationNumber
	 */
	public function setData(array $data)
	{
		foreach ($data as $key => $value)
		{
			switch ($key)
			{
				case 'organisationNumber':
					$this->setOrganisationNumber($value);
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
	public function getOrganisationNumber()
	{
		return $this->_organisationNumber;
	}

	/**
	 * {@inheritdoc}
	 * @return OrganisationNumber
	 */
	public function setOrganisationNumber($organisationNumber)
	{
		$this->_organisationNumber = $organisationNumber;
		return $this;
	}
}
