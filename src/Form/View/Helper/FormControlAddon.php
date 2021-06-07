<?php

namespace Lemo\Bootstrap\Form\View\Helper;

use Laminas\Form\ElementInterface;

class FormControlAddon extends AbstractHelper
{
    protected string $template = '<span class="input-group-addon">%s</span>';

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
     * Render addon
     *
     * @param  ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element): string
    {
        $string = '';

        if (null !== $element->getOption('addon')) {
            $addon = $element->getOption('addon');

            if (null !== ($translator = $this->getTranslator())) {
                $addon = $translator->translate(
                    $addon, $this->getTranslatorTextDomain()
                );
            }

            $string .= sprintf($this->getTemplate(), $addon);
        }

        return $string;
    }

    /**
     * Set template for addon
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
     * Get template for addon
     *
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }
}
