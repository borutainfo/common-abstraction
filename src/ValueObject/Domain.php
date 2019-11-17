<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\ValueObject;


use Boruta\CommonAbstraction\Exception\ValueObjectException;

/**
 * Class Domain
 * @package Boruta\CommonAbstraction\ValueObject
 */
class Domain implements ValueObjectInterface
{
    /**
     * @var string
     */
    protected $value;

    /**
     * Domain constructor.
     * @param $value
     */
    public function __construct($value)
    {
        if (!$this->validate($value)) {
            throw new ValueObjectException('Domain is incorrect!');
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
        return (bool)\filter_var($value, FILTER_VALIDATE_DOMAIN);
    }
}
