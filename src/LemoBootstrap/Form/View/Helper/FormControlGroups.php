<?php

namespace LemoBootstrap\Form\View\Helper;

use LemoBootstrap\Form\View\Helper\FormControlGroup;
use Zend\Form\ElementInterface;
use Zend\Form\Element\Collection as CollectionElement;
use Zend\Form\FieldsetInterface;
use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\View\Helper\FormElement as ZendFormElement;

class FormControlGroups extends AbstractHelper
{
    /**
     * The view helper used to render sub fieldsets.
     *
     * @var AbstractHelper
     */
    protected $fieldsetHelper;

    /**
     * @var FormControlGroup
     */
    protected $helperControlGroup;

    /**
     * @var ZendFormElement
     */
    protected $helperElement;

    /**
     * @var
     */
    protected $renderAsInline;

    /**
     * Invoke helper as function
     * Proxies to {@link render()}.
     *
     * @param  ElementInterface|null $element
     * @param  bool                  $renderAsInline
     * @return string|FormControlGroups
     */
    public function __invoke(ElementInterface $element = null, $renderAsInline = false)
    {
        if (!$element) {
            return $this;
        }

        $this->renderAsInline = $renderAsInline;

        return $this->render($element, $renderAsInline);
    }

    /**
     * Render a collection by iterating through all fieldsets and elements
     *
     * @param  ElementInterface $element
     * @param  bool             $renderAsInline
     * @return string
     */
    public function render(ElementInterface $element, $renderAsInline = false)
    {
        $renderer = $this->getView();
        if (!method_exists($renderer, 'plugin')) {
            // Bail early if renderer is not pluggable
            return '';
        }

        $this->renderAsInline = $renderAsInline;

        $markup             = '';
        $templateMarkup     = '';
        $helperControlGroup = $this->getHelperControlGroup();
        $fieldsetHelper   = $this->getFieldsetHelper();

        if ($element instanceof CollectionElement && $element->shouldCreateTemplate()) {
            $templateMarkup = $this->renderTemplate($element);
        }

        foreach ($element->getIterator() as $elementOrFieldset) {
            if ($elementOrFieldset instanceof FieldsetInterface) {
                if (true === $this->renderAsInline) {
                    $markup .= $helperControlGroup($elementOrFieldset);
                } else {
                    $markup .= $fieldsetHelper($elementOrFieldset);
                }
            } elseif ($elementOrFieldset instanceof ElementInterface) {
                if (true === $this->renderAsInline) {
                    $markup .= $helperControlGroup($elementOrFieldset);
                } else {
                    $markup .= $helperControlGroup($elementOrFieldset);
                }
            }
        }

        // If $templateMarkup is not empty, use it for simplify adding new element in JavaScript
        if (!empty($templateMarkup)) {
            $markup .= $templateMarkup;
        }

        return $markup;
    }

    /**
     * Only render a template
     *
     * @param  CollectionElement $collection
     * @return string
     */
    public function renderTemplate(CollectionElement $collection)
    {
        $elementHelper          = $this->getHelperElement();
        $escapeHtmlAttribHelper = $this->getEscapeHtmlAttrHelper();
        $templateMarkup         = '';
        $helperControlGroup = $this->getHelperControlGroup();

        $elementOrFieldset = $collection->getTemplateElement();

        if ($elementOrFieldset instanceof FieldsetInterface) {
            if (true === $this->renderAsInline) {
                $templateMarkup .= $helperControlGroup($elementOrFieldset);
            } else {
                $templateMarkup .= $this->render($elementOrFieldset);
            }
        } elseif ($elementOrFieldset instanceof ElementInterface) {
            if (true === $this->renderAsInline) {
                $templateMarkup .= $helperControlGroup($elementOrFieldset);
            } else {
                $templateMarkup .= $helperControlGroup($elementOrFieldset);
            }
        }

        $templateId = $collection->getName();

        return sprintf(
            '<span id="control-template-' . $templateId . '" data-template="%s"></span>',
            $escapeHtmlAttribHelper($templateMarkup)
        );
    }

    /**
     * Retrieve the FormControlGroups helper
     *
     * @return FormControlGroups
     */
    protected function getHelperControlGroup()
    {
        if ($this->helperControlGroup) {
            return $this->helperControlGroup;
        }

        if (!$this->helperControlGroup instanceof FormControlGroup) {
            $this->helperControlGroup = new FormControlGroup();
        }

        $this->helperControlGroup->setView($this->getView());

        return $this->helperControlGroup;
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

    /**
     * Sets the fieldset helper that should be used by this collection.
     *
     * @param  AbstractHelper $fieldsetHelper The fieldset helper to use.
     * @return FormControlGroups
     */
    public function setFieldsetHelper(AbstractHelper $fieldsetHelper)
    {
        $this->fieldsetHelper = $fieldsetHelper;
        return $this;
    }

    /**
     * Retrieve the fieldset helper.
     *
     * @return FormControlGroups
     */
    protected function getFieldsetHelper()
    {
        if ($this->fieldsetHelper) {
            return $this->fieldsetHelper;
        }

        return $this;
    }
}
