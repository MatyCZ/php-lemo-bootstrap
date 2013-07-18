<?php

namespace LemoBootstrap\Form\View\Helper;

use LemoBootstrap\Exception;
use LemoBootstrap\Form\View\Helper\FormElementHelpBlock;
use LemoBootstrap\Form\View\Helper\FormElementHelpInline;
use Zend\Form\Element\Hidden;
use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormRow as FormRowHelper;

class FormRow extends FormRowHelper
{
    /**
     * @var FormElementHelpBlock
     */
    protected $elementHelpBlock;

    /**
     * @var FormElementHelpInline
     */
    protected $elementHelpInline;

    /**
     * @var string
     */
    protected $labelPosition = 'xxx';

    /**
     * @var string
     */
    protected $status;

    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @param null|ElementInterface $element
     * @param null|string           $labelPosition
     * @param bool                  $renderErrors
     * @param null|string           $partial
     * @return string|FormRow
     */
    public function __invoke(ElementInterface $element = null, $labelPosition = null, $renderErrors = null, $partial = null)
    {
        if (!$element) {
            return $this;
        }

        if ($labelPosition !== null) {
            $this->setLabelPosition($labelPosition);
        }

        if ($renderErrors !== null){
            $this->setRenderErrors($renderErrors);
        }

        if ($partial !== null) {
            $this->setPartial($partial);
        }

        return $this->render($element);
    }

    /**
     * Utility form helper that renders a label (if it exists), an element and errors
     *
     * @param  ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $helperEscapeHtml        = $this->getEscapeHtmlHelper();
        $helperLabel             = $this->getLabelHelper();
        $helperElement           = $this->getElementHelper();
        $helperElementErrors     = $this->getElementErrorsHelper();
        $helperElementHelpBlock  = $this->getElementHelpBlockHelper();
        $helperElementHelpInline = $this->getElementHelpInlineHelper();

        $label           = $element->getLabel();
        $options         = $element->getOptions();
        $inputErrorClass = $this->getInputErrorClass();
        $elementErrors   = $helperElementErrors->setAttributes(array('class' => 'errors'))->render($element);

        // Does this element have errors ?
        if (!empty($elementErrors) && !empty($inputErrorClass)) {
            $classAttributes = ($element->hasAttribute('class') ? $element->getAttribute('class') . ' ' : '');
            $classAttributes = $classAttributes . $inputErrorClass;

            $element->setAttribute('class', $classAttributes);
            $this->setStatus('error');
        }

        if ($this->renderErrors && !empty($elementErrors)) {
            $options['help-block'] = $elementErrors;

            $element->setOptions($options);
        }

        $elementString     = $helperElement->render($element);
        $elementHelpInline = $helperElementHelpInline->render($element);
        $elementHelpBlock  = $helperElementHelpBlock->render($element);

        // Add helps to element string
        $elementString .= $elementHelpInline . $elementHelpBlock;

        // Wrap html to element string
        $elementString = '<div class="controls">' . $elementString . '</div>';

        if (isset($label) && '' !== $label) {
            $label = $helperEscapeHtml($label);
            $labelAttributes = $element->getLabelAttributes();

            if (empty($labelAttributes)) {
                $labelAttributes = $this->labelAttributes;
            }
            if(!is_array($labelAttributes) || !array_key_exists('for', $labelAttributes)) {
                $labelAttributes['for'] = $this->getId($element);
            }

            $labelOpen  = $helperLabel->openTag($labelAttributes);
            $labelClose = $helperLabel->closeTag();

            switch ($this->getLabelPosition()) {
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

        $hideCondition = '';
        if(true === $element->getOption('hide') || $element instanceof Hidden) {
            $hideCondition = ' hide';
        }

        return sprintf(
            '<div class="control-group%s%s" id="control-group-%s">%s</div>',
            $this->getStatus(),
            $hideCondition,
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
     * Retrieve the FormElementHelpBlock helper
     *
     * @return FormElementHelpBlock
     */
    protected function getElementHelpBlockHelper()
    {
        if ($this->elementHelpBlock) {
            return $this->elementHelpBlock;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->elementHelpBlock = $this->view->plugin('form_element_help_block');
        }

        if (!$this->elementHelpBlock instanceof FormElementHelpBlock) {
            $this->elementHelpBlock = new FormElementHelpBlock();
        }

        return $this->elementHelpBlock;
    }

    /**
     * Retrieve the FormElementHelpInline helper
     *
     * @return FormElementHelpInline
     */
    protected function getElementHelpInlineHelper()
    {
        if ($this->elementHelpInline) {
            return $this->elementHelpInline;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->elementHelpInline = $this->view->plugin('form_element_help_inline');
        }

        if (!$this->elementHelpInline instanceof FormElementHelpInline) {
            $this->elementHelpInline = new FormElementHelpInline();
        }

        return $this->elementHelpInline;
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
