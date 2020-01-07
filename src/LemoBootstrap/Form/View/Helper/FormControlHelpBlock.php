<?php

namespace LemoBootstrap\Form\View\Helper;

use Laminas\Form\ElementInterface;

class FormControlHelpBlock extends AbstractHelper
{
    /**
     * Template for block help
     *
     * @var string
     */
    protected $template = '<span class="help-block">%s</span>';

    /**
     * Magical Invoke Method
     *
     * @param  ElementInterface $element
     * @return string|FormControlHelpBlock
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

        if (null !== $element->getOption('help-block')) {
            $help = $element->getOption('help-block');

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
     * @return FormControlHelpBlock
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
