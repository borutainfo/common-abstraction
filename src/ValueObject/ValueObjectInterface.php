<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\ValueObject;


/**
 * Interface ValueObjectInterface
 * @package Boruta\CommonAbstraction\ValueObject
 */
interface ValueObjectInterface
{
    /**
     * @return mixed
     */
    public function value();
}
