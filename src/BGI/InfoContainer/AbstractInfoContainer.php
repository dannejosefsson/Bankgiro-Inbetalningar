<?php
/**
 * Abstract info container. The concrete classes will use a parser and several
 * row objects to handle one stage of the file.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\InfoContainer;

use BGI\Visitor\VisitorInterface;

use BGI\Visitor\VisitInfoContainerInterface;

use BGI\Visitor\NodeInterface;

use BGI\Row\Parser\ParserInterface;
use BGI\Row\Object\ObjectInterface;
/**
 * Abstract info container. The concrete classes will use a parser and several
 * row objects to handle one stage of the file.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @uses		BGI\InfoContainer.InfoContainerInterface
 * @abstract
 */
abstract class AbstractInfoContainer implements InfoContainerInterface, NodeInterface
{
	/**#@+ @access protected */
	/**
	 * Start post transaction code.
	 * @static
	 * @var int|string|array
	 */
	protected static $_startPostTransactionCode = null;

	/**
	 * Associative array with transaction code as key and a parser as value.
	 * @var array
	 */
	protected $_rowParsers = array();

	/**
	 * State of the info container.
	 * @var string
	 */
	protected $_state = self::STATE_IDLE;

	/**
	 * Found errors.
	 * @var array
	 */
	protected $_errors = array();

	/**
	 * Low level info container type.
	 * @var \BGI\InfoContainer\InfoContainerInterface()
	 */
	protected $_lowerLevelInfoContainerType;

	/**
	 * Low level info containers.
	 * @var array Consists of \BGI\InfoContainer\InfoContainerInterface()
	 */
	protected $_lowerLevelInfoContainers = array();
	/**#@- */

	/**#@+
	 * State machine state.
	 */
	const STATE_IDLE	= 'Idle';
	const STATE_ERROR	= 'Error occured';

	/**#@- */

	/**
	 * Sets row parsers.
	 * @abstract
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 */
	abstract public function __construct();

	/**
	 * {@inheritdoc}
	 * @abstract
	 */
	abstract public function handleObject(ObjectInterface $object);

	/**
	 * {@inheritdoc}
	 * @throws InfoContainerException
	 */
	public static function getStartTransactionCode()
	{
		if(is_null(static::$_startPostTransactionCode))
		{
			throw new InfoContainerException('The info container must have an start transaction id set.');
		}
		else return static::$_startPostTransactionCode;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setRowParser($transactionCode, ParserInterface $rowParserObject)
	{
		$this->_rowParsers[$transactionCode] = $rowParserObject;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 * @uses	AbstractInfoContainer::$_state
	 */
	public function getState($option = null)
	{
		return $this->_state;
	}

	/**
	 * Set the state.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	string $state
	 * @uses	AbstractInfoContainer::$_state
	 */
	protected function setState($state)
	{
		$this->_state = $state;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setError($errorMsg)
	{
		$this->_state = self::STATE_ERROR;
		$this->_errors[] = $errorMsg;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getErrors()
	{
		return $this->_errors;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setLowerLevelInfoContainerType(
						InfoContainerInterface $infoContainerInterfaceType)
	{
		$this->_lowerLevelInfoContainerType = $infoContainerInterfaceType;
		return $this;
	}

	/**
	 * Get a new lower level info container.
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @uses	AbstractInfoContainer::$_lowerLevelInfoContainerType
	 * @return	InfoContainerInterface
	 */
	protected function getLowerLevelInfoContainer()
	{
		return new $this->_lowerLevelInfoContainerType();
	}

	/**
	 * {@inheritdoc}
	 * @uses	InfoContainerInterface::getStartTransactionCode()
	 */
	public static function isStartPost($transactionCode)
	{
		$transactionCodeContainer = self::getStartTransactionCode();
		if (is_string($transactionCodeContainer))
		{
			return (!strcmp($transactionCodeContainer, $transactionCode))? true: false;
		}
		elseif (is_array($transactionCodeContainer))
		{
			return in_array($transactionCode, $transactionCodeContainer);
		}
		else
		{
			return false;
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function parseRow($transactionCode, $rowData)
	{
		$state = false;
		// Make sure that this container can parse this type of row.
		if(array_key_exists($transactionCode, $this->_rowParsers))
		{
			$object = $this->_rowParsers[$transactionCode]->
							parseRow($transactionCode, $rowData);
			if(	$object instanceof ObjectInterface &&
				strcmp(	$this->_rowParsers[$transactionCode]->getState(),
						self::STATE_ERROR))
			{
				$this->handleObject($object);
				$state = $this->getState();
			}
			else
			{
				$errorMsg = "Could not parse row with transaction code ";
				$errorMsg .= $transactionCode;
				$this->setError($errorMsg);
				$state = $this->getState();
			}
		}
		// Check if this container has sub containers.
		// If so, let this container try to parse the row.
		elseif (	($containerType = $this->_lowerLevelInfoContainerType)
					instanceof InfoContainerInterface)
		{
			if ($containerType::isStartPost($transactionCode))
			{
				$this->_lowerLevelInfoContainers[] =
					$this->getLowerLevelInfoContainer();
			}
			else
			{
				if (!strcmp(self::STATE_ERROR, $state))
				{
					$this->setError(end($this->_lowerLevelInfoContainers)
										->getErrors());
				}
			}
			$state = end($this->_lowerLevelInfoContainers)->
						parseRow($transactionCode, $rowData);
		}
		else
		{
			$errorMsg = "Lowest container reached: Transaction code ";
			$errorMsg .= $transactionCode . " not known.";
			$this->setError($errorMsg);
			$state = $this->getState();
		}
		return $state;
	}

	/**
	* Check if the value of left and right are the same.
	* If not; set the container to error state with the dynamic variableName.
	* @author	Daniel Josefsson <dannejosefsson@gmail.com>
	* @access	protected
	* @param 	string|int	$left
	* @param 	string|int	$right
	* @param 	string	$variableName
	* @return 	boolean
	*/
	protected function checkConsistancy( $left, $right, $variableName )
	{
		if (is_int($left) && is_int($right) && !((int) $left - (int) $right))
		{
			return true;
		}
		elseif ( is_string($left) && is_string($right) && !strcmp($left, $right) )
		{
			return true;
		}
		else
		{
			$error = "$variableName parsed and given in post are not consistent. ";
			$error .= "Parsed: ".$left." Given: ".$right;
			$this->setError($error);
			return false;
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function getErrorsRecursevly()
	{
		$errors = $this->getErrors();
		if (is_array($this->_lowerLevelInfoContainers))
		{
			foreach ($this->_lowerLevelInfoContainers as $lLContainer)
			{
				$lLContainerErrors = $lLContainer->getErrors();
				if (!empty($lLContainerErrors))
				{
					$errors[] = $lLContainerErrors;
				}
			}
		}
		return $errors;
	}

	/**
	 * {@inheritdoc}
	 * @abstract
	 */
	abstract public function accept(VisitorInterface $visitor);
}
