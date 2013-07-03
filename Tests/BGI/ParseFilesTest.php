<?php
/**
 * Transaction post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace Tests\BGI;

use \BGI\BgiFileParser;

class ParseFilesTest extends AbstractFiles
{
	protected $bgifp;

	protected function setUp() {
		parent::setUp();
		$this->_bgifp = new \BGI\BgiFileParser();
	}

	/**
	 * @test
	 */
	public function bgTestfiles() {
		foreach ($this->_files as $file) {
			$this->_bgifp = new \BGI\BgiFileParser();
			$this->_bgifp->parseFile($file);
// 			var_dump($this->_bgifp->getErrors());
			$this->assertEquals(BgiFileParser::STATE_FILE_COMPLETLY_PARSED, $this->_bgifp->getState(), $file);
			$this->assertEmpty($this->_bgifp->getErrorsRecursevly());
			unset($this->_bgifp);
		}
	}
}
