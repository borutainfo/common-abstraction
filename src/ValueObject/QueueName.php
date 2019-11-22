<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\ValueObject;


use Boruta\CommonAbstraction\Exception\ValueObjectException;

/**
 * Class QueueName
 * @package Boruta\CommonAbstraction\ValueObject
 */
class QueueName implements ValueObjectInterface
{
    /**
     * @var string
     */
    protected $value;

    /**
     * QueueName constructor.
     * @param $value
     * @throws ValueObjectException
     */
    public function __construct($value)
    {
        if (!$this->validate($value)) {
            throw new ValueObjectException('Queue name is incorrect!');
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
        return \is_string($value) && \preg_match('/^[a-zA-Z0-9\-\_]+$/', $value);
    }
}
