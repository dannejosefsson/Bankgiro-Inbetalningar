<?php
/**
 * Transaction post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace Tests\BGI;

abstract class AbstractFiles extends \PHPUnit_Framework_TestCase
{
	protected $_files;

	protected function setUp() {
		parent::setUp();
		$filedir = dirname(__FILE__).'/';
		$this->_files =
			array(	$filedir.'../Files/BgMaxfil1.txt',
					$filedir.'../Files/BgMaxfil2.txt',
					$filedir.'../Files/BgMaxfil3.txt',
					$filedir.'../Files/BgMaxfil4.txt',
					$filedir.'../Files/BgMaxfil5.txt'
			);
	}
}