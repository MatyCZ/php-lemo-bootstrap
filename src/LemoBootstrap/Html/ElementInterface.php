<?php

namespace LemoBootstrap\Html;

interface ElementInterface
{
    /**
     * Set all attributes at once
     *
     * @param  array|\Traversable $options
     * @return ElementInterface
     */
    public function setOptions($options);

    /**
     * Retrieve all attributes at once
     *
     * @return array
     */
    public function getOptions();

    /**
     * Set a single option for an element
     *
     * @param  string $key
     * @param  mixed $value
     * @return self
     */
    public function setOption($key, $value);

    /**
     * Retrieve a single element option
     *
     * @param string $option
     * @return null|mixed
     */
    public function getOption($option);

    /**
     * Set a single element attribute
     *
     * @param  string $key
     * @param  mixed $value
     * @return ElementInterface
     */
    public function setAttribute($key, $value);

    /**
     * Retrieve a single element attribute
     *
     * @param  string $key
     * @return mixed
     */
    public function getAttribute($key);

    /**
     * Return true if a specific attribute is set
     *
     * @param  string $key
     * @return bool
     */
    public function hasAttribute($key);

    /**
     * Add a single attribute value
     *
     * @param  string $key
     * @param  mixed  $value
     * @return ElementInterface
     */
    public function addAttributeValue($key, $value);

    /**
     * Remove a single attribute value
     *
     * @param  string $key
     * @param  mixed  $value
     * @return ElementInterface
     */
    public function removeAttributeValue($key, $value);

    /**
     * Set many attributes at once
     *
     * Implementation will decide if this will overwrite or merge.
     *
     * @param  array|\Traversable $arrayOrTraversable
     * @return ElementInterface
     */
    public function setAttributes($arrayOrTraversable);

    /**
     * Retrieve all attributes at once
     *
     * @return array|\Traversable
     */
    public function getAttributes();

    /**
     * Set the content of the element
     *
     * @param  mixed $content
     * @return ElementInterface
     */
    public function setContent($content);

    /**
     * Retrieve the element content
     *
     * @return mixed
     */
    public function getContent();
}
