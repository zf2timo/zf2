<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Stdlib\Hydrator\Strategy;

use Zend\Stdlib\Exception\InvalidArgumentException;

class BooleanStrategy implements StrategyInterface
{
    /**
     * @var int|string
     */
    protected $trueValue;

    /**
     * @var int|string
     */
    protected $falseValue;

    public function __construct($trueValue, $falseValue)
    {
        $this->trueValue = $trueValue;
        $this->falseValue = $falseValue;
    }

    /**
     * Converts the given value so that it can be extracted by the hydrator.
     *
     * @param  mixed  $value  The original value.
     * @param  object $object (optional) The original object for context.
     * @return mixed  Returns the value that should be extracted.
     */
    public function extract($value)
    {
        if (is_object($value) || !is_bool($value)) {
            throw new InvalidArgumentException(sprintf(
                'Unable to extract. Expected bool. %s was given.',
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }

        if ($value === true) {
            return $this->getTrueValue();
        }

        return $this->getFalseValue();
    }

    /**
     * Converts the given value so that it can be hydrated by the hydrator.
     *
     * @param  mixed $value The original value.
     * @param  array $data  (optional) The original data for context.
     * @return mixed Returns the value that should be hydrated.
     */
    public function hydrate($value)
    {
        if (!is_string($value) && !is_int($value)) {
            throw new InvalidArgumentException(sprintf(
                'Unable to hydrate. Expected string or int. %s was given.',
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }

        if ($value === $this->getTrueValue()) {
            return true;
        }

        if ($value === $this->getFalseValue()) {
            return false;
        }

        throw new InvalidArgumentException(sprintf(
            'Unexpected value %s can\'t be hydrated. Expect %s or %s as Value.',
            $value,
        $this->getTrueValue(),
        $this->getFalseValue()
        ));
    }

    /**
     * @return int|string
     */
    public function getTrueValue()
    {
        return $this->trueValue;
    }

    /**
     * @return int|string
     */
    public function getFalseValue()
    {
        return $this->falseValue;
    }
}
