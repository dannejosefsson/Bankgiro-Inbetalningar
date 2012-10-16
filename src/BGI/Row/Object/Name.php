<?php
/**
 * Name object.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Object;

/**
 * Name object.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractObject
 * @uses		NameInterface
 */
class Name extends AbstractObject implements NameInterface
{
	/**#@+ @access protected */
	/**
	 * Name.
	 */
	protected $_name;

	/**
	 * Extra name.
	 */
	protected $_extraName;
	/**#@- */

	/**
	 * {@inheritdoc}
	 * @return Name
	 */
	public function setData(array $data)
	{
		foreach ($data as $key => $value)
		{
			switch ($key)
			{
				case 'name':
					$this->setName($value);
					break;
				case 'extraName':
					$this->setExtraName($value);
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
	public function getName()
	{
		return $this->_name;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getExtraName()
	{
		return $this->_extraName;
	}

	/**
	 * {@inheritdoc}
	 * @return Name
	 */
	public function setName($name)
	{
		$this->_name = $name;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return Name
	 */
	public function setExtraName($extraName)
	{
		$this->_extraName = $extraName;
		return $this;
	}
}
