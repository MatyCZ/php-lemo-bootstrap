<?php

namespace Lemo\Bootstrap\Form\View\Helper;

use Laminas\Form\ElementInterface;

class FormControlButton extends AbstractHelper
{
    protected string $template = '<span class="input-group-btn">%s</span>';

    /**
     * Magical Invoke Method
     *
     * @param  ElementInterface|null $element
     * @return string|self
     */
    public function __invoke(?ElementInterface $element = null)
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
    public function render(ElementInterface $element): string
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
     * @return self
     */
    public function setTemplate(string $template): self
    {
        $this->template = $template;
        return $this;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }
}
