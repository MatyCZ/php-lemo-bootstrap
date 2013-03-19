<?php

namespace LemoBootstrap\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\AbstractHelper;

class FormElementHelp extends AbstractHelper
{
    /**
     * Template for block help
     *
     * @var string
     */
    protected $templateBlock = '<span class="help-block">%s</span>';

    /**
     * Template for inline help
     *
     * @var string
     */
    protected $templateInline = '<span class="help-inline">%s</span>';

    /**
     * Magical Invoke Method
     *
     * @param  ElementInterface $element
     * @return string|FormElementHelp
     */
    public function __invoke(ElementInterface $element = null)
    {
        if (null === $element) {
            return $this;
        }

        return $this->render($element);
    }

    /**
     * Render
     *
     * @param  ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $content = '';

        if (null !== $element->getOption('help-block')) {
            $content .= sprintf($this->getTemplateBlock(), $element->getOption('help-block'));
        }
        if (null !== $element->getOption('help-inline')) {
            $content .= sprintf($this->getTemplateInline(), $element->getOption('help-inline'));
        }

        return $content;
    }

    /**
     * Set template for block help
     *
     * @param  string $blockWrapper
     * @return FormElementHelp
     */
    public function setTemplateBlock($blockWrapper)
    {
        $this->templateBlock = (string) $blockWrapper;

        return $this;
    }

    /**
     * Get template for block help
     *
     * @return string
     */
    public function getTemplateBlock()
    {
        return $this->templateBlock;
    }

    /**
     * Set template for inline help
     *
     * @param  string $inlineWrapper
     * @return FormElementHelp
     */
    public function setTemplateInline($inlineWrapper)
    {
        $this->templateInline = (string) $inlineWrapper;

        return $this;
    }

    /**
     * Get template for inline help
     *
     * @return string
     */
    public function getTemplateInline()
    {
        return $this->templateInline;
    }
}
