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
	 * <code><?php $this->getParser('organisationNumber'); ?></code>
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
			case StartInterface::_name:
				return new Start();
			case OpeningInterface::_name:
				return new Opening();
			case SummationInterface::_name:
				return new Summation();
			case EndInterface::_name:
				return new End();
			case TransactionInterface::_name:
				return new Transaction();
			case NameInterface::_name:
				return new Name();
			case AddressOneInterface::_name:
				return new AddressOne();
			case AddressTwoInterface::_name:
				return new AddressTwo();
			case OrganisationNumberInterface::_name:
				return new OrganisationNumber();
			case InformationInterface::_name:
				return new Information();
			default:
				$errorMsg = $parserType. ' is not a valid parser.';
				throw new ParserException($errorMsg);
			break;
		}
	}
}
