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
     * Render
     *
     * @param ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $escapeHtmlHelper = $this->getEscapeHtmlHelper();

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

        $elementString = parent::render($element);
        $insertString = array();

        foreach(array('prepend', 'append') as $key) {
            if (array_key_exists($key, $element->getOptions())) {
                $options = $element->getOption($key);

                if (!is_array($options)) {
                    $options = (array) $options;
                }

                foreach ($options as $option) {
                    $insertString['input-' . $key][] = '<span class="add-on">' . $escapeHtmlHelper($option) . '</span>';
                }
            }
        }

        if(!empty($insertString)) {
            $wrapperOpen = '<div class="' . implode(' ', array_keys($insertString)) . '">';
            $wrapperClose = '</div>';

            $prepend = null;
            $append = null;

            if(array_key_exists('input-prepend', $insertString)) {
                $prepend = implode(PHP_EOL, $insertString['input-prepend']);
            }
            if(array_key_exists('input-append', $insertString)) {
                $append = implode(PHP_EOL, $insertString['input-append']);
            }

            $elementString = $wrapperOpen . $prepend . $elementString . $append . $wrapperClose;
        }

        return $elementString;
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
}
