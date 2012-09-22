<?php
namespace BGI\Row\Object;

interface ObjectInterface
{
	/**
	 * Pass the data to populate the object.
	 * @param array $data
	 */
	public function __construct(array $data = array());

	/**
	 * Pass the data to populate the object.
	 * @param array $data
	 */
	public function setData(array $data);
}
