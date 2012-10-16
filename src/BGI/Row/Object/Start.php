<?php
/**
 * Start object.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Object;

/**
 * Start object.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		AbstractObject
 * @uses		StartInterface
 */
class Start extends AbstractObject implements StartInterface
{
	/**#@+ @access protected */
	/**
	 * Layout.
	 * @var string
	 */
	protected $_layout;

	/**
	 * Version.
	 * @var int|string
	 */
	protected $_version;

	/**
	 * Date
	 * @var string
	 */
	protected $_date;

	/**
	 * Micro seconds.
	 * @var int
	 */
	protected $_microSeconds;

	/**
	 * File marker.
	 * @var int|string
	 */
	protected $_fileMarker;
	/**#@- */

	/**
	 * {@inheritdoc}
	 * @return	Start
	 */
	public function setData(array $data)
	{
		foreach ($data as $key => $value)
		{
			switch ($key)
			{
				case 'layout':
					$this->setLayout($value);
					break;
				case 'version':
					$this->setVersion($value);
					break;
				case 'date':
					$this->setDate($value);
					break;
				case 'microSeconds':
					$this->setMicroSeconds($value);
					break;
				case 'fileMarker':
					$this->setFileMarker($value);
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
	public function getLayout()
	{
		return $this->_layout;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getVersion()
	{
		return $this->_version;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDate()
	{
		return $this->_date;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getMicroSeconds()
	{
		return $this->_microSeconds;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFileMarker()
	{
		return $this->_fileMarker;
	}

	/**
	 * {@inheritdoc}
	 * @return	Start
	 */
	public function setLayout($layout)
	{
		$this->_layout = $layout;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return	Start
	 */
	public function setVersion($version)
	{
		$this->_version = $version;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return	Start
	 */
	public function setDate($date)
	{
		$this->_date = $date;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return	Start
	 */
	public function setMicroSeconds($microSeconds)
	{
		$this->_microSeconds = $microSeconds;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @return	Start
	 */
	public function setFileMarker($fileMarker)
	{
		$this->_fileMarker = $fileMarker;
		return $this;
	}
}
