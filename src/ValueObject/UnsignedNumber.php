<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\ValueObject;


use Boruta\CommonAbstraction\Exception\ValueObjectException;

/**
 * Class UnsignedNumber
 * @package Boruta\CommonAbstraction\ValueObject
 */
class UnsignedNumber implements ValueObjectInterface
{
    /**
     * @var int
     */
    protected $value;

    /**
     * UnsignedNumber constructor.
     * @param $value
     * @throws ValueObjectException
     */
    public function __construct($value)
    {
        if (!$this->validate($value)) {
            throw new ValueObjectException('Number is incorrect!');
        }
        $this->value = (int)$value;
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function validate($value): bool
    {
        return is_numeric($value) && (int)$value >= 0 && (string)(int)$value === (string)$value;
    }
}
