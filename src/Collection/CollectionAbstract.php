<?php declare(strict_types=1);
/**
 * @author Sebastian Boruta <sebastian@boruta.info>
 */

namespace Boruta\CommonAbstraction\Collection;


use Boruta\CommonAbstraction\Exception\InvalidCollectionElementException;
use Boruta\CommonAbstraction\ValueObject\ValueObjectInterface;
use Cartalyst\Collections\Collection;

/**
 * Class CollectionAbstract
 * @package Boruta\CommonAbstraction\Collection
 */
abstract class CollectionAbstract extends Collection
{
    protected const ELEMENT_CLASS = null;

    /**
     * @param mixed $value
     * @throws InvalidCollectionElementException
     */
    public function push($value): void
    {
        $this->verifyElement($value);
        parent::push($value);
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @throws InvalidCollectionElementException
     */
    public function put($key, $value): void
    {
        $this->verifyElement($value);
        parent::put($key, $value);
    }

    /**
     * @param mixed $value
     * @throws InvalidCollectionElementException
     */
    protected function verifyElement($value): void
    {
        if (self::ELEMENT_CLASS === null) {
            return;
        }

        if (!is_object($value) || get_class($value) !== self::ELEMENT_CLASS) {
            throw new InvalidCollectionElementException('Invalid type of given value!');
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        if (empty($this->items)) {
            return [];
        }

        if ($this->first() instanceof ValueObjectInterface) {
            $data = [];
            /** @var ValueObjectInterface $value */
            foreach ($this->items as $key => $value) {
                $data[$key] = $value->value();
            }
            return $data;
        }

        return parent::toArray();
    }
}
