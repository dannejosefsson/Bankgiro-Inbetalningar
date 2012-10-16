<?php
/**
 * This file contains the default BankgiroInbetalningar file parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI;

use BGI\InfoContainer as InfoContainer;

/**
 * BgiFileParser
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
class BgiFileParser
{
	/**#@+ @access protected */

	/**
	 * Array storing errors
	 * @var array of strings
	 */
	protected	$_errors = array();

	/**
	 * File name
	 * @var string
	 */
	protected $_filename;

	/**
	 * Contains data from file name.
	 * @var array of strings
	 */
	protected $_fileData;

	/**
	 * File info container.
	 * @var BGI\InfoContainer\InfoContainerInterface
	 */
	protected $_fileInfoContainer;

	/**
	 * State of file parser
	 * @var string
	 */
	protected $_state = self::STATE_IDLE;
	/**#@- */

	/**#@+
	 * State machine state.
	 */
	const STATE_IDLE					= 'Idle';
	const STATE_ERROR					= 'Error occured';
	const STATE_PARSING					= 'Parsing file';
	const STATE_FILE_COMPLETLY_PARSED	= 'File completly parsed';
	/**#@- */

	/**
	 * Sets the file info container.
	 * @uses BgiFileParser::setFileInfoContainer()
	 */
	public function __construct()
	{
		$this->setFileInfoContainer();
	}

	/**
	 * Get filename.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @uses	BgiFileParser::$_filename
	 * @return string
	 */
	public function getFilename()
	{
		return $this->_filename;
	}

	/**
	 * Sets a new filename. Sets STATE_ERROR if the file is not found.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	string $newFilename	path and filename.
	 * @uses	BgiFileParser::_filename
	 * @uses	BgiFileParser::setError()
	 * @return	BgiFileParser
	 */
	public function setFilename( $newFilename )
	{
		if (	isset($newFilename) && strcmp("", $newFilename )
				&& file_exists($newFilename))
		{
			$this->_filename = $newFilename;
		}
		else
		{
			$this->setError("$newFilename is not a file.");
		}
		return $this;
	}

	/**
	 * Reads and stores earlier given file. Sets state to error on failure.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @uses	BgiFileParser::$fileData
	 * @uses	BgiFileParser::getFilename()
	 * @uses	BgiFileParser::setError()
	 * @return 	BgiFileParser
	 */
	public function readFile()
	{
		// Clear array to make sure that not old data is parsed again.
		$this->_fileData=array();
		$fileName = $this->getFilename();
		if ($openFile = file($fileName))
		{
			foreach ($openFile as $lineNum => $line)
			{
				$this->_fileData[$lineNum] = $line;
			}
		}
		else
		{
			$this->setError("Failed to read ". $fileName);
		}
		return $this;
	}

	/**
	 * Parses given file. Sets state to error if parser cannot parse correctly.
	 * Sets state to completly parsed if so.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	string $filename
	 * @uses	BgiFileParser::setFilename()
	 * @uses	BgiFileParser::getFilename()
	 * @uses	BgiFileParser::getState()
	 * @uses	BgiFileParser::setState()
	 * @uses	BgiFileParser::readFile()
	 * @uses	BgiFileParser::$_fileData
	 * @uses	BgiFileParser::getInfoContainer()
	 * @uses	BgiFileParser::STATE_ERROR
	 * @uses	BgiFileParser::STATE_PARSING
	 * @uses	BgiFileParser::STATE_FILE_COMPLETLY_PARSED
	 * @uses	InfoContainer.AbstractInfoContainer::STATE_ERROR
	 * @return	BgiFileParser
	 */
	public function parseFile( $filename = null )
	{
		if (!is_null($filename))
		{
			$this->setFilename($filename);
		}
		$return = false;

		// Read file if setFilename succeded.
		if ( strcmp($this->getState(), self::STATE_ERROR) )
		{
			$this->setState(self::STATE_PARSING);
			$this->readFile();
		}

		// Parse if readFile succeded.
		if ( strcmp($this->getState(), self::STATE_ERROR) )
		{
			setlocale(LC_CTYPE, 'sv_SE.UTF8');
			$lineNr = 1;
			foreach ($this->_fileData as $line)
			{
				$transactionCode = substr($line, 0, 2);
				$rowData = substr($line, 2, 78);
				if (is_numeric($transactionCode))
				{
					$state = $this->getFileInfoContainer()->
								parseRow($transactionCode, $rowData);
				}
				if (!strcmp(InfoContainer\AbstractInfoContainer::STATE_ERROR,
							$state))
				{
					$this->setError('Error at line '. $lineNr .
									' in ' . $this->getFilename());
					return $this;
				}
				$lineNr++;
			}
		}
		$this->setState(self::STATE_FILE_COMPLETLY_PARSED);
		return $this;
	}

	/**
	 * Returns errors.
	 * @author	Daniel Josefsson
	 * @uses	BgiFileParser::$_errors
	 * @return	array of strings
	 */
	public function getErrors()
	{
		return $this->_errors;
	}

	/**
	 * Sets new error.
	 * @author	Daniel Josefsson
	 * @param	string $error
	 * @uses	BgiFileParser::setState()
	 * @uses	BgiFileParser::$_errors
	 * @return	BgiFileParser
	 */
	public function setError( $error )
	{
		$this->setState(self::STATE_ERROR);
		$this->_errors[] = $error;
		return $this;
	}

	/**
	 * Returns the state for the parser.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @uses	BgiFileParser::$_state
	 * @return	string
	 */
	public function getState()
	{
		return $this->_state;
	}

	/**
	 * Gets errors recursevly throughout all info containers.
	 * @uses BgiFileParser::getErrors()
	 * @uses BgiFileParser::getFileInfoContainer()
	 * @uses InfoContainer.InfoContainerInterface::getErrorsRecursevly()
	 * @author Daniel Josefsson <dannejosefsson@gmail.com>
	 */
	public function getErrorsRecursevly()
	{
		$errors = array();
		$errors = $this->getErrors();
		$childErrors = $this->getFileInfoContainer()->getErrorsRecursevly();
		if (!empty($childErrors))
		{
			$errors[] = $childErrors;
		}
		return $errors;
	}

	/**
	 * Sets the file info container to its property.
	 * @author Daniel Josefsson <dannejosefsson@gmail.com>
	 * @access protected
	 * @uses	InfoContainer.InfoContainerFactory()
	 * @uses	InfoContainer.InfoContainerFactory::getFile()
	 * @uses	BgiFileParser::$_fileInfoContainer
	 * @return \BGI\BgiFileParser
	 */
	protected function setFileInfoContainer()
	{
			$infoContainerFactory = new InfoContainer\InfoContainerFactory();
			$this->_fileInfoContainer = $infoContainerFactory->getFile();
		return $this;
	}

	/**
	 * Gets the file info container and loads it silencly if neccesary.
	 * @uses	BgiFileParser::$_fileInfoContainer
	 * @uses	BgiFileParser::setFileInfoContainer()
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 */
	protected function getFileInfoContainer()
	{
		if (!$this->_fileInfoContainer instanceof InfoContainer\InfoContainerInterface)
		{
			$this->setFileInfoContainer();
		}
		return $this->_fileInfoContainer;
	}

	/**
	 * Sets the state
	 * @author Daniel Josefsson <dannejosefsson@gmail.com>
	 * @uses	BgiFileParser::$_state
	 * @param string $state
	 */
	protected function setState($state)
	{
		$this->_state = $state;
	}
}
