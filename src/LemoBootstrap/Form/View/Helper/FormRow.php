<?php

namespace LemoBootstrap\Form\View\Helper;

use LemoBootstrap\Exception;
use LemoBootstrap\Form\View\Helper\FormElementHelp;
use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormRow as FormRowHelper;

class FormRow extends FormRowHelper
{
    const LABEL_APPEND = 'append';
    const LABEL_DEFAULT = null;
    const LABEL_PREPEND = 'prepend';

    /**
     * @var FormElementHelp
     */
    protected $elementHelpHelper;

    /**
     * @var string
     */
    protected $labelPosition = self::LABEL_DEFAULT;

    /**
     * @var string
     */
    protected $status;

    /**
     * Utility form helper that renders a label (if it exists), an element and errors
     *
     * @param  ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $helperEscapeHtml    = $this->getEscapeHtmlHelper();
        $helperLabel         = $this->getLabelHelper();
        $helperElement       = $this->getElementHelper();
        $helperElementErrors = $this->getElementErrorsHelper();
        $helperElementHelp   = $this->getElementHelpHelper();

        $label           = $element->getLabel();
        $inputErrorClass = $this->getInputErrorClass();
        $elementErrors   = $helperElementErrors->setAttributes(array('class' => 'help-inline'))->render($element);
        $elementHelp   = $helperElementHelp->render($element);

        // Does this element have errors ?
        if (!empty($elementErrors) && !empty($inputErrorClass)) {
            $classAttributes = ($element->hasAttribute('class') ? $element->getAttribute('class') . ' ' : '');
            $classAttributes = $classAttributes . $inputErrorClass;

            $element->setAttribute('class', $classAttributes);
            $this->setStatus('error');
        }

        $elementString = $helperElement->render($element) . $elementErrors;

        if (!$this->renderErrors || empty($elementErrors)) {
            $elementString .= $elementHelp;
        }

        $elementString = '<div class="controls">' . $elementString . '</div>';

        if (isset($label) && '' !== $label) {
            // Translate the label
            if (null !== ($translator = $this->getTranslator())) {
                $label = $translator->translate(
                    $label, $this->getTranslatorTextDomain()
                );
            }

            $label = $helperEscapeHtml($label);
            $labelAttributes = $element->getLabelAttributes();

            if (empty($labelAttributes)) {
                $labelAttributes = $this->labelAttributes;
            }
            if(!is_array($labelAttributes) || !array_key_exists('for', $labelAttributes)) {
                $labelAttributes['for'] = $this->getId($element);
            }

            if ($element->hasAttribute('id')) {
                $labelOpen = '';
                $labelClose = '';
                $label = $helperLabel($element);
            } else {
                $labelOpen  = $helperLabel->openTag($labelAttributes);
                $labelClose = $helperLabel->closeTag();
            }

            switch ($this->labelPosition) {
                case self::LABEL_PREPEND:
                    $elementString = $labelOpen . $label . $elementString . $labelClose;
                    break;
                case self::LABEL_APPEND:
                    $elementString = $labelOpen . $elementString . $label . $labelClose;
                    break;
                default:
                    $elementString = $labelOpen . $label . $labelClose . $elementString;
                    break;
            }
        }

        return sprintf(
            '<div class="control-group %s" id="control-group-%s">%s</div>',
            $this->getStatus(),
            $this->getId($element),
            $elementString
        );
    }

    /**
     * @param  string|null $status
     * @throws Exception\InvalidArgumentException
     * @return FormRow
     */
    public function setStatus($status)
    {
        if(null !== $status) {
            $status = strtolower($status);
            $statuses = array('error', 'info', 'success', 'warning');

            if(!in_array($status, $statuses)) {
                throw new Exception\InvalidArgumentException(sprintf(
                    'Invalid status given. Status must be one of \'%s\'',
                    implode(', ', $statuses)
                ));
            }

            $this->status = $status;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Retrieve the FormElement helper
     *
     * @return FormElement
     */
    protected function getElementHelper()
    {
        if ($this->elementHelper) {
            return $this->elementHelper;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->elementHelper = $this->view->plugin('form_element');
        }

        if (!$this->elementHelper instanceof FormElement) {
            $this->elementHelper = new FormElement();
        }

        return $this->elementHelper;
    }

    /**
     * Retrieve the FormElementErrors helper
     *
     * @return FormElementErrors
     */
    protected function getElementErrorsHelper()
    {
        if ($this->elementErrorsHelper) {
            return $this->elementErrorsHelper;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->elementErrorsHelper = $this->view->plugin('form_element_errors');
        }

        if (!$this->elementErrorsHelper instanceof FormElementErrors) {
            $this->elementErrorsHelper = new FormElementErrors();
        }

        return $this->elementErrorsHelper;
    }

    /**
     * Retrieve the FormElementHelp helper
     *
     * @return FormElementHelp
     */
    protected function getElementHelpHelper()
    {
        if ($this->elementHelpHelper) {
            return $this->elementHelpHelper;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->elementHelpHelper = $this->view->plugin('form_element_help');
        }

        if (!$this->elementHelpHelper instanceof FormElementHelp) {
            $this->elementHelpHelper = new FormElementHelp();
        }

        return $this->elementHelpHelper;
    }

    /**
     * Retrieve the FormLabel helper
     *
     * @return FormLabel
     */
    protected function getLabelHelper()
    {
        if ($this->labelHelper) {
            return $this->labelHelper;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->labelHelper = $this->view->plugin('form_label');
        }

        if (!$this->labelHelper instanceof FormLabel) {
            $this->labelHelper = new FormLabel();
        }

        if ($this->hasTranslator()) {
            $this->labelHelper->setTranslator(
                $this->getTranslator(),
                $this->getTranslatorTextDomain()
            );
        }

        return $this->labelHelper;
    }
}
