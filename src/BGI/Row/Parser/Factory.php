<?php
/**
 * Parser factory.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
namespace BGI\Row\Parser;

/**
 * Parser factory.
 * @license	http://www.gnu.org/licenses/gpl.html
 * @author		Daniel Josefsson <dannejosefsson@gmail.com>
 */
class Factory
{
	/**
	 * Returns parser depending on input. Give a type given in Uses as camel
	 * case.
	 * <code><?php>$this->getParser('organisationNumber');<?></code>
	 * @author	Daniel Josefsson <dannejosefsson@gmail.com>
	 * @param	string $parserType
	 * @uses	Start
	 * @uses	Opening
	 * @uses	Summation
	 * @uses	End
	 * @uses	Name
	 * @uses	AdderesOne
	 * @uses	AddressTwo
	 * @uses	OrganisationNumber
	 * @uses	Information
	 * @throws ParserException
	 */
	public function getParser($parserType)
	{
		switch ($parserType)
		{
			case 'start':
				return new Start();
			case 'opening':
				return new Opening();
			case 'summation':
				return new Summation();
			case 'end':
				return new End();
			case 'transaction':
				return new Transaction();
			case 'name':
				return new Name();
			case 'addressOne':
				return new AddressOne();
			case 'addressTwo':
				return new AddressTwo();
			case 'organisationNumber':
				return new OrganisationNumber();
			case 'information':
				return new Information();
			default:
				$errorMsg = $parserType. ' is not a valid parser.';
				throw new ParserException($errorMsg);
			break;
		}
	}
}
