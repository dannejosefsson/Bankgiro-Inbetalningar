<?php
/**
 * Transaction post parser.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace Tests\BGI;

class TestFilesTest extends AbstractFiles
{
	/**
	 * @test
	 */
	public function filesExist() {
		foreach ($this->_files as $file) {
			$this->assertTrue(file_exists($file));
		}
	}

	/**
	 * Bankgiro Inbetalningar files are coded in sv_SE.ISO-8859-1.
	 * @test
	 * @depends filesExist
	 */
	public function locale() {
		$localString = "25Här är betalning från mig till dig                                            \r\n";
		$content = file($this->_files[0]);
		$fixed = mb_convert_encoding($content[3], "UTF-8", "ISO-8859-1");
		$this->assertEquals($localString, $fixed);
	}

}