<?php

namespace LemoBootstrap\Form\View\Helper;

use Zend\Form\ElementInterface;

class FormControlAddon extends AbstractHelper
{
    /**
     * Template for addon
     *
     * @var string
     */
    protected $template = '<span class="input-group-addon">%s</span>';

    /**
     * Magical Invoke Method
     *
     * @param  ElementInterface $element
     * @return string|FormControlAddon
     */
    public function __invoke(ElementInterface $element = null)
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
    public function render(ElementInterface $element)
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
     * @return FormControlAddon
     */
    public function setTemplate($template)
    {
        $this->template = (string) $template;
        return $this;
    }

    /**
     * Get template for addon
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
