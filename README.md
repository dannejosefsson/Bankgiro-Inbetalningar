Bankgiro-Inbetalningar
==============================================
This module is a Bankgiro Inbetalningar parser where [BG6040][] is the specification behind the code. PHP 5.3.10 was used.

Usage
-----
```php
$parser = new \BGI\BgiFileParser();
$parser->parseFile($file);
```
Testing
-------
Tests were conducted with PHPUnit 3.7.21.

Testfiles needed to conduct the tests are:
*   [BgMaxfil1][]
*   [BgMaxfil2][]
*   [BgMaxfil3][]
*   [BgMaxfil4][]
*   [BgMaxfil5][]

and they should be placed in Tests/Files folder.

Some of the test files are not complying to the given standard and this has been reported to BGC several times, but nothing is corrected as 2013-07-02.
###Problems###
* In [BgMaxfil4][] row 18 is one char to long (81 instead of 80), remove the 
	last space to make the tests comply.
* Some transactions (in, [BgMaxfil3][], [BgMaxfil4][] and [BgMaxfil5][])
	with multiple references has a comma as delimiter. This is not given 
	explicit in [BG6040][]. The implementation takes care of that.

TODO
----
- [ ] Avibildmarkering and parsing of such pictures is not started.
- [ ] $parser->getData;

  [BG6040]: http://www.bgc.se/templates/Trycksaksearch____3199.aspx#
  [BgMaxfil1]: http://www.bgc.se/upload/Gemensamt/Exempelfiler/BgMaxfil1.txt
  [BgMaxfil2]: http://www.bgc.se/upload/Gemensamt/Exempelfiler/BgMaxfil2.txt
  [BgMaxfil3]: http://www.bgc.se/upload/Gemensamt/Exempelfiler/BgMaxfil3.txt
  [BgMaxfil4]: http://www.bgc.se/upload/Gemensamt/Exempelfiler/BgMaxfil4.txt
  [BgMaxfil5]: http://www.bgc.se/upload/Gemensamt/Exempelfiler/BgMaxfil5.txt
  [Avibild]: http://www.bgc.se/upload/Gemensamt/Exempelfiler/Bildfil%20991-2346.tif
