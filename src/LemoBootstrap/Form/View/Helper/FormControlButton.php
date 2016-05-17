<?php

namespace LemoBootstrap\Form\View\Helper;

use Zend\Form\ElementInterface;

class FormControlButton extends AbstractHelper
{
    /**
     * Template for button
     *
     * @var string
*/
    protected $template = '<span class="input-group-btn">%s</span>';

    /**
     * Magical Invoke Method
     *
     * @param  ElementInterface $element
     * @return string|FormControlButton
     */
    public function __invoke(ElementInterface $element = null)
    {
        if (null === $element) {
            return $this;
        }

        return $this->render($element);
    }

    /**
     * Render button
     *
     * @param  ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $string = '';

        if (null !== $element->getOption('button')) {
            $button = $element->getOption('button');

            $string .= sprintf($this->getTemplate(), $button);
        }

        return $string;
    }

    /**
     * Set template
     *
     * @param  string $template
     * @return FormControlButton
     */
    public function setTemplate($template)
    {
        $this->template = (string) $template;
        return $this;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
