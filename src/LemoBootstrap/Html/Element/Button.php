<?php

namespace LemoBootstrap\Html\Element;

use LemoBootstrap\Exception;
use LemoBootstrap\Html\Element;
use LemoBootstrap\Html\ElementInterface;
use Traversable;

class Button extends Element
{
    /**
     * Seed attributes
     *
     * @var array
     */
    protected $attributes = array(
        'class' => 'btn',
        'type' => 'button',
    );

    /**
     * Glyphicon element
     *
     * @var Glyphicon
     */
    protected $glyphicon;

    /**
     * Set glyphicon name
     *
     * @param  array|Glyphicon $glyphicon
     * @return Glyphicon
     * @throws Exception\InvalidArgumentException
     */
    public function setGlyphicon($glyphicon)
    {
        if (!$glyphicon instanceof Glyphicon) {
            if (is_object($glyphicon) && !$glyphicon instanceof Traversable) {
                throw new Exception\InvalidArgumentException(sprintf(
                    'Expected instance of LemoBootstrap\Html\Element\Glyphicon; received "%s"',
                    get_class($glyphicon))
                );
            }

            $glyphicon = new Glyphicon($glyphicon);
        }

        $this->glyphicon = $glyphicon;
        return $this;
    }

    /**
     * Retreive glyphicon element
     *
     * @return Glyphicon
     */
    public function getGlyphicon()
    {
        return $this->glyphicon;
    }

    /**
     * Set options for an element. Accepted options are:
     * - icon: glyphicon name
     *
     * @param  array|Traversable $options
     * @return Button|ElementInterface
     */
    public function setOptions($options)
    {
        parent::setOptions($options);

        if (isset($this->options['glyphicon'])) {
            $this->setGlyphicon($this->options['glyphicon']);
        }

        return $this;
    }
}
