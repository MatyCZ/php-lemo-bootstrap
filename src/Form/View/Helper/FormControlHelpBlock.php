<?php

namespace Lemo\Bootstrap\Form\View\Helper;

use Laminas\Form\ElementInterface;

class FormControlHelpBlock extends AbstractHelper
{
    protected string $template = '<span class="help-block">%s</span>';

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
     * Render block help
     *
     * @param  ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element): string
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
    public function setTemplate(string $template): self
    {
        $this->template = $template;
        return $this;
    }

    /**
     * Get template for help
     *
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }
}
