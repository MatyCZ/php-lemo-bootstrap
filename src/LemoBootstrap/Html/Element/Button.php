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
        'type'  => 'button',
    );

    /**
     * FontAwesome element
     *
     * @var FontAwesome
     */
    protected $fontAwesome;

    /**
     * Glyphicon element
     *
     * @var Glyphicon
     */
    protected $glyphicon;

    /**
     * Set FontAwesome name
     *
     * @param  array|FontAwesome $fontAwesome
     * @return FontAwesome
     * @throws Exception\InvalidArgumentException
     */
    public function setFontAwesome($fontAwesome)
    {
        if (!$fontAwesome instanceof FontAwesome) {
            if (is_object($fontAwesome) && !$fontAwesome instanceof Traversable) {
                throw new Exception\InvalidArgumentException(sprintf(
                    'Expected instance of LemoBootstrap\Html\Element\FontAwesome; received "%s"',
                    get_class($fontAwesome))
                );
            }

            $fontAwesome = new FontAwesome($fontAwesome);
        }

        $this->fontAwesome = $fontAwesome;
        return $this;
    }

    /**
     * Retreive fontAwesome element
     *
     * @return FontAwesome
     */
    public function getFontAwesome()
    {
        return $this->fontAwesome;
    }

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

        if (isset($this->options['fontawesome'])) {
            $this->setFontAwesome($this->options['fontawesome']);
        }

        if (isset($this->options['glyphicon'])) {
            $this->setGlyphicon($this->options['glyphicon']);
        }

        return $this;
    }
}
