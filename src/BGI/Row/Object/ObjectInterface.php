<?php
namespace BGI\Row\Object;

/**
 * This interface declares the methods required for an class to be able to
 * fulfill the role as an BGI\Row\Object.
 * @author Daniel Josefsson <dannejosefsson@gmail.com>
 */
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

	/**
	 * Return the transaction code.
	 */
	public function getTransactionCode();

	/**
	 * Set the transaction code.
	 * @param string $transactionCode
	 */
	public function setTransactionCode($transactionCode);
}
