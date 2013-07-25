<?php

namespace LemoBootstrap\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\View\Helper\FormElement as ZendFormElement;

class FormControls extends AbstractHelper
{
    /**
     * @var ZendFormElement
     */
    protected $helperElement;

    /**
     * @var string
     */
    protected $templateCloseTag = '</div>';

    /**
     * @var string
     */
    protected $templateOpenTag = '<div class="controls">';

    /**
     * Render form controls
     *
     * @param  null|ElementInterface $element
     * @param  null|string           $formStyle
     * @return string
     */
    public function __invoke(ElementInterface $element = null, $formStyle = null)
    {
        if (null === $element) {
            return $this;
        }

        return $this->render($element);
    }

    /**
     * Render
     *
     * @param ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $helperElement = $this->getHelperElement();

        $content = '';

        if (is_array($element) || $element instanceof \Traversable) {
            foreach ($element as $el) {
                $content .= $helperElement($el);
            }
        } else {
            $content .= $helperElement($element);
        }

        return $this->openTag($element) . $content . $this->closeTag();
    }

    /**
     * Generate an opening form tag
     *
     * @param  ElementInterface $element
     * @return string
     */
    public function openTag(ElementInterface $element)
    {
        $id = $element->getAttribute('id') ? : $element->getName();

        return sprintf(
            $this->templateOpenTag,
            $id
        );
    }

    /**
     * Generate a closing form tag
     *
     * @return string
     */
    public function closeTag()
    {
        return $this->templateCloseTag;
    }

    /**
     * Retrieve the FormElement helper
     *
     * @return ZendFormElement
     */
    protected function getHelperElement()
    {
        if ($this->helperElement) {
            return $this->helperElement;
        }

        if (method_exists($this->getView(), 'plugin')) {
            $this->helperElement = $this->getView()->plugin('form_element');
        }

        if (!$this->helperElement instanceof ZendFormElement) {
            $this->helperElement = new ZendFormElement();
        }

        $this->helperElement->setView($this->getView());

        return $this->helperElement;
    }
}
