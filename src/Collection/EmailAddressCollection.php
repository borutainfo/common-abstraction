<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Collection;


use Boruta\CommonAbstraction\ValueObject\EmailAddress;

/**
 * Class EmailAddressCollection
 * @package Boruta\CommonAbstraction\Collection
 */
class EmailAddressCollection extends CollectionAbstract
{
    protected const ELEMENT_CLASS = EmailAddress::class;
}
