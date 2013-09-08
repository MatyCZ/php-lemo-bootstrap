<?php

namespace LemoBootstrap\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormElement as FormElementHelper;
use Zend\View\Helper\EscapeHtml as EscapeHtmlHelper;

class FormElement extends FormElementHelper
{
    /**
     * @var EscapeHtmlHelper
     */
    protected $escapeHtmlHelper;

    /**
     * List of elements with value options
     *
     * @var array
     */
    protected $elementsValueOptions = array(
        'multi_checkbox',
        'multicheckbox',
        'radio',
    );

    /**
     * @var FormElementAppend
     */
    protected $helperElementAppend;

    /**
     * @var FormElementHelpBlock
     */
    protected $helperElementHelpBlock;
    /**
     * @var FormElementPrepend
     */
    protected $helperElementPrepend;

    /**
     * Render
     *
     * @param ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $escapeHtmlHelper = $this->getEscapeHtmlHelper();
        $helperElementAppend = $this->getHelperElementAppend();
        $helperElementHelpBlock  = $this->getHelperElementHelpBlock();
        $helperElementPrepend = $this->getHelperElementPrepend();

        $id   = $element->getAttribute('id') ? : $element->getAttribute('name');
        $type = strtolower($element->getAttribute('type'));

        // Add class to value options for multicheckbox and radio elements
        if (in_array($type, $this->elementsValueOptions)) {
            $class = ($type === 'radio') ? 'radio' : 'checkbox';

            $valueOptions = $element->getValueOptions();
            $valueOptionsUpd = array();

            foreach($valueOptions as $key => $spec) {
                if(!is_array($spec)) {
                    $valueOptionsUpd[] = array(
                        'label' => $spec,
                        'label_attributes' => array('class' => $class),
                        'value' => $key,
                    );
                } else {
                    if(array_key_exists('label_attributes', $spec) && array_key_exists('class', $spec['label_attributes'])) {
                        if(false === strpos($spec['label_attributes'], $class)) {
                            $spec['label_attributes']['class'] = trim($spec['label_attributes'] . ' ' . $class);
                        }
                    } else {
                        $spec['label_attributes'] = array('class' => $class);
                    }
                }
            }

            $element->setValueOptions($valueOptionsUpd);
        }

        $element->setAttribute('id', $id);

        $content = '';

        if (null !== $element->getOption('append') || null !== $element->getOption('prepend')) {
            $content .= '<div class="input-group">' . PHP_EOL;
        }

        $content .= $helperElementPrepend($element) . PHP_EOL;
        $content .= parent::render($element) . PHP_EOL;
        $content .= $helperElementAppend($element) . PHP_EOL;

        if (null !== $element->getOption('append') || null !== $element->getOption('prepend')) {
            $content .= '</div>' . PHP_EOL;
        }

        if (count($element->getMessages()) > 0) {
            $options = $element->getOptions();

            $options['help-block'] = implode('<br />', $element->getMessages() );

            $element->setOptions($options);
        }

        $content .= $helperElementHelpBlock($element) . PHP_EOL;

        return $content;
    }

    /**
     * Retrieve the EscapeHtml helper
     *
     * @return EscapeHtmlHelper
     */
    protected function getEscapeHtmlHelper()
    {
        if ($this->escapeHtmlHelper) {
            return $this->escapeHtmlHelper;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->escapeHtmlHelper = $this->view->plugin('escapehtml');
        }

        if (!$this->escapeHtmlHelper instanceof EscapeHtmlHelper) {
            $this->escapeHtmlHelper = new EscapeHtmlHelper();
        }

        return $this->escapeHtmlHelper;
    }

    /**
     * Retrieve the FormElementAppend helper
     *
     * @return FormElementAppend
     */
    protected function getHelperElementAppend()
    {
        if ($this->helperElementAppend) {
            return $this->helperElementAppend;
        }

        if (!$this->helperElementAppend instanceof FormElementAppend) {
            $this->helperElementAppend = new FormElementAppend();
        }

        $this->helperElementAppend->setView($this->getView());

        return $this->helperElementAppend;
    }

    /**
     * Retrieve the FormElementHelpBlock helper
     *
     * @return FormElementHelpBlock
     */
    protected function getHelperElementHelpBlock()
    {
        if ($this->helperElementHelpBlock) {
            return $this->helperElementHelpBlock;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->helperElementHelpBlock = $this->view->plugin('form_element_help_block');
        }

        if (!$this->helperElementHelpBlock instanceof FormElementHelpBlock) {
            $this->helperElementHelpBlock = new FormElementHelpBlock();
        }

        return $this->helperElementHelpBlock;
    }

    /**
     * Retrieve the FormElementPrepend helper
     *
     * @return FormElementPrepend
     */
    protected function getHelperElementPrepend()
    {
        if ($this->helperElementPrepend) {
            return $this->helperElementPrepend;
        }

        if (!$this->helperElementPrepend instanceof FormElementPrepend) {
            $this->helperElementPrepend = new FormElementPrepend();
        }

        $this->helperElementPrepend->setView($this->getView());

        return $this->helperElementPrepend;
    }
}
