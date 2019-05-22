<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\ValueObject;


use Boruta\CommonAbstraction\Exception\ValueObjectException;

/**
 * Class RawString
 * @package Boruta\CommonAbstraction\ValueObject
 */
class RawString implements ValueObjectInterface
{
    /**
     * @var string
     */
    protected $value;

    /**
     * RawString constructor.
     * @param $value
     * @throws ValueObjectException
     */
    public function __construct($value)
    {
        if (!$this->validate($value)) {
            throw new ValueObjectException('String is incorrect!');
        }
        $this->value = (string)$value;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function validate($value): bool
    {
        return \is_string($value);
    }
}
