<?php
/**
 * Information object.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Object;

/**
 * Information object.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractObject
 * @uses		InformationInterface
 */
class Information extends AbstractObject implements InformationInterface
{
	/**
	 * Information.
	 * @access	protected
	 * @var		string
	 */
	protected $_information;

	/**
	 * {@inheritdoc}
	 * @return Information
	 */
	public function setData(array $data)
	{
		foreach ($data as $key => $value)
		{
			switch ($key)
			{
				case 'information':
					$this->setInformation($value);
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
	public function getInformation()
	{
		return $this->_information;
	}

	/**
	 * {@inheritdoc}
	 * @return	Information
	 */
	public function setInformation($information)
	{
		$this->_information = $information;
		return $this;
	}
}
