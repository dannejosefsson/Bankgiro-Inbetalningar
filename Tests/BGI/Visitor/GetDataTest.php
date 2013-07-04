<?php
/**
 * Test BGI\Visitor\GetData
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
class GetDataTest extends \Tests\BGI\AbstractFiles {
	/**
	 * @dataProvider dataOfBgMaxfil1
	 * @test
	 */
	public function getData($result) {
		$this->_bgifp = new \BGI\BgiFileParser();
		$this->_bgifp->parseFile($this->_files[0]);
		$data = $this->_bgifp->getData();

		echo "<pre>";
		var_dump($data);
		echo "</pre>";
		$this->assertEquals($result, $data);
	}

	public function dataOfBgMaxfil1() {
		return array(array('01'));
	}
}
