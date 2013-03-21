<?php

namespace LemoBootstrap\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\AbstractHelper;

class FormElementHelpInline extends AbstractHelper
{
    /**
     * Template for help
     *
     * @var string
     */
    protected $template = '<span class="help-inline">%s</span>';

    /**
     * Magical Invoke Method
     *
     * @param  ElementInterface $element
     * @return string|FormElementHelpInline
     */
    public function __invoke(ElementInterface $element = null)
    {
        if (null === $element) {
            return $this;
        }

        return $this->render($element);
    }

    /**
     * Render inline help
     *
     * @param  ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $string = '';

        if (null !== $element->getOption('help-inline')) {
            $help = $element->getOption('help-inline');

            if (null !== ($translator = $this->getTranslator())) {
                $help = $translator->translate(
                    $help, $this->getTranslatorTextDomain()
                );
            }

            $string .= sprintf($this->getTemplate(), $help);
        }

        return $string;
    }

    /**
     * Set template for inline help
     *
     * @param  string $template
     * @return FormElementHelpInline
     */
    public function setTemplate($template)
    {
        $this->template = (string) $template;

        return $this;
    }

    /**
     * Get template for inline help
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
