<?php

namespace LemoBootstrap\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\AbstractHelper;

class FormElementPrepend extends AbstractHelper
{
    /**
     * Template for help
     *
     * @var string
     */
    protected $template = '<span class="input-group-addon">%s</span>';

    /**
     * Magical Invoke Method
     *
     * @param  ElementInterface $element
     * @return string|FormElementPrepend
     */
    public function __invoke(ElementInterface $element = null)
    {
        if (null === $element) {
            return $this;
        }

        return $this->render($element);
    }

    /**
     * Render block help
     *
     * @param  ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $string = '';

        if (null !== $element->getOption('prepend')) {
            $help = $element->getOption('prepend');

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
     * Set template for help
     *
     * @param  string $template
     * @return FormElementPrepend
     */
    public function setTemplate($template)
    {
        $this->template = (string) $template;

        return $this;
    }

    /**
     * Get template for help
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
