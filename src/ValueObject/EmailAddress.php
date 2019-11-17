<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\ValueObject;


use Boruta\CommonAbstraction\Exception\ValueObjectException;

/**
 * Class EmailAddress
 * @package Boruta\CommonAbstraction\ValueObject
 */
class EmailAddress implements ValueObjectInterface
{
    /**
     * @var string
     */
    protected $value;

    /**
     * EmailAddress constructor.
     * @param $value
     * @throws ValueObjectException
     */
    public function __construct($value)
    {
        if (!$this->validate($value)) {
            throw new ValueObjectException('Email address is incorrect!');
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
        return \filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
