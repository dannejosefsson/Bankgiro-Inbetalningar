<?php
/**
* @copyright	Copyright © 2012 Daniel Josefsson. All rights reserved.
* @license		GPL v3
* @example 		$payments = new Bgi( array("/path/to/filename") );
* 				echo "<pre>";
*					var_dump($payments);
*				echo "</pre>";
*/

/**
 * Bankgiro Inbetalningar (Bgi)
 *
 * A class made for parse a Bankgiro Inbetalningar file eg.
 * parse it to a php array and return.
 *
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 * @version     0.1
 */

class Bgi
{
	protected $_filename;
	protected $_fileData;

	/**
	 *
	 * The option parameter consists of string or an array
	 * containing filename.
	 * The option parameter is not mandatory.
	 *
	 * @param array/string $options
	 */
	public function __construct( $options = null )
	 {
		if ( is_array($options) )
		{
			$this->setFilename($options[0]);
		}
		elseif ( is_string( $options ) )
		{
			$this->setFilename($options);
		}
	}

	/**
	 * @method getFilename
	 * @return _filename
	 */
	public function getFilename()
	{
		return $this->_filename;
	}

	/**
	 *	@method	setFilename
	 *	@param 	newFilename
	 *	@return	this
	 */
	public function setFilename( $newFilename )
	{
		if ( isset($newFilename) && "" != $newFilename )
		{
			$this->_filename = $newFilename;
		}
		return $this;
	}

	/**
	* @method getFileData
	* @return _fileData
	*/
	public function getFileData()
	{
		return $this->_fileData;
	}

	/**
	 *	@method	setFileData
	 *	@param 	newFileData
	 *	@return	this
	 */
	private function setFileData( $newFileData )
	{
		$this->_fileData = $newFileData;
		return $this;
	}

}