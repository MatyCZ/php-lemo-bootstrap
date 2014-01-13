<?php

namespace LemoBootstrap\Html;

use LemoBootstrap\Exception;
use Traversable;
use Zend\Stdlib\ArrayUtils;

class Element implements
    ElementAttributeRemovalInterface,
    ElementInterface
{
    /**
     * @var array
     */
    protected $attributes = array();

    /**
     * @var mixed
     */
    protected $content;

    /**
     * @var array
     */
    protected $options = array();

    /**
     * @param  array $options Optional options for the element
     * @throws Exception\InvalidArgumentException
     */
    public function __construct($options = array())
    {
        if (!empty($options)) {
            $this->setOptions($options);
        }
    }

    /**
     * This function is automatically called when creating element with factory. It
     * allows to perform various operations (add elements...)
     *
     * @return void
     */
    public function init()
    {
    }

    /**
     * Set options for an element
     *
     * @param  array|Traversable $options
     * @return Element|ElementInterface
     * @throws Exception\InvalidArgumentException
     */
    public function setOptions($options)
    {
        if ($options instanceof Traversable) {
            $options = ArrayUtils::iteratorToArray($options);
        } elseif (!is_array($options)) {
            throw new Exception\InvalidArgumentException(
                'The options parameter must be an array or a Traversable'
            );
        }

        $this->options = $options;

        return $this;
    }

    /**
     * Get defined options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Return the specified option
     *
     * @param string $option
     * @return NULL|mixed
     */
    public function getOption($option)
    {
        if (!isset($this->options[$option])) {
            return null;
        }

        return $this->options[$option];
    }

    /**
     * Set a single option for an element
     *
     * @param  string $key
     * @param  mixed $value
     * @return Element|ElementInterface
     */
    public function setOption($key, $value)
    {
        $this->options[$key] = $value;
        return $this;
    }

    /**
     * Add a single attribute value
     *
     * @param  string $key
     * @param  mixed  $value
     * @return Element|ElementInterface
     */
    public function addAttributeValue($key, $value)
    {
        if (!isset($this->attributes[$key])) {
            $this->setAttribute($key, $value);
            return $this;
        }

        $attribute = $this->attributes[$key];
        $attribute = trim($attribute . ' ' . $value);

        $this->attributes[$key] = $attribute;
        return $this;
    }

    /**
     * Remove a single attribute value
     *
     * @param  string $key
     * @param  mixed  $value
     * @return ElementInterface
     */
    public function removeAttributeValue($key, $value)
    {
        $attribute = $this->attributes[$key];
        $attribute = trim(str_replace($value, '', $attribute));

        if ('' == $attribute) {
            unset($this->attributes[$key]);
            return $this;
        }

        $this->attributes[$key] = trim($attribute);
        return $this;
    }

    /**
     * Set a single element attribute
     *
     * @param  string $key
     * @param  mixed  $value
     * @return Element|ElementInterface
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * Retrieve a single element attribute
     *
     * @param  $key
     * @return mixed|null
     */
    public function getAttribute($key)
    {
        if (!array_key_exists($key, $this->attributes)) {
            return null;
        }
        return $this->attributes[$key];
    }

    /**
     * Remove a single attribute
     *
     * @param string $key
     * @return ElementInterface
     */
    public function removeAttribute($key)
    {
        unset($this->attributes[$key]);
        return $this;
    }

    /**
     * Does the element has a specific attribute ?
     *
     * @param  string $key
     * @return bool
     */
    public function hasAttribute($key)
    {
        return array_key_exists($key, $this->attributes);
    }

    /**
     * Set many attributes at once
     *
     * Implementation will decide if this will overwrite or merge.
     *
     * @param  array|Traversable $arrayOrTraversable
     * @return Element|ElementInterface
     * @throws Exception\InvalidArgumentException
     */
    public function setAttributes($arrayOrTraversable)
    {
        if (!is_array($arrayOrTraversable) && !$arrayOrTraversable instanceof Traversable) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s expects an array or Traversable argument; received "%s"',
                __METHOD__,
                (is_object($arrayOrTraversable) ? get_class($arrayOrTraversable) : gettype($arrayOrTraversable))
            ));
        }
        foreach ($arrayOrTraversable as $key => $value) {
            $this->setAttribute($key, $value);
        }
        return $this;
    }

    /**
     * Retrieve all attributes at once
     *
     * @return array|Traversable
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Remove many attributes at once
     *
     * @param array $keys
     * @return ElementInterface
     */
    public function removeAttributes(array $keys)
    {
        foreach ($keys as $key) {
            unset($this->attributes[$key]);
        }

        return $this;
    }

    /**
     * Clear all attributes
     *
     * @return Element|ElementInterface
     */
    public function clearAttributes()
    {
        $this->attributes = array();
        return $this;
    }

    /**
     * Set the element content
     *
     * @param  mixed $content
     * @return Element
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Retrieve the element content
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }
}
