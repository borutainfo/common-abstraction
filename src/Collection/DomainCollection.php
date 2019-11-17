<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Collection;


use Boruta\CommonAbstraction\ValueObject\Domain;

/**
 * Class DomainCollection
 * @package Boruta\CommonAbstraction\Collection
 */
class DomainCollection extends CollectionAbstract
{
    protected const ELEMENT_CLASS = Domain::class;
}
