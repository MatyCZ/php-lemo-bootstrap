<?php

namespace LemoBootstrap\Form\View\Helper;

use LemoBootstrap\Form\View\Helper\FormControlAddon;
use LemoBootstrap\Form\View\Helper\FormControlHelpBlock;
use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\View\Helper\FormElement;

class FormControl extends AbstractHelper
{
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
     * @var FormElement
     */
    protected $helperFormElement;

    /**
     * @var FormControlAddon
     */
    protected $helperFormControlAddon;

    /**
     * @var FormControlHelpBlock
     */
    protected $helperFormControlHelpBlock;

    /**
     * Invoke helper as function
     *
     * Proxies to {@link render()}.
     *
     * @param  ElementInterface|null $element
     * @return string|FormControl
     */
    public function __invoke(ElementInterface $element = null)
    {
        if (!$element) {
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
        $helperFormElement = $this->getHelperFormElement();
        $helperFormControlAddon = $this->getHelperFormControlAddon();
        $helperFormControlHelpBlock  = $this->getHelperFormControlHelpBlock();

        $id   = $element->getAttribute('id') ? : $element->getAttribute('name');
        $type = strtolower($element->getAttribute('type'));
        $classCheckboxOrRadio = null;
        $content = '';

        // Renderovani datumu dle locale
        if ($element->getValue() instanceof \DateTime) {
            $formatter = new \IntlDateFormatter(
                \Locale::getDefault(),
                \IntlDateFormatter::MEDIUM,
                \IntlDateFormatter::NONE,
                $element->getValue()->getTimezone()->getName(),
                \IntlDateFormatter::GREGORIAN
            );

            $element->setValue($formatter->format($element->getValue()));
        }

        // Add class to value options for multicheckbox and radio elements
        if (in_array($type, $this->elementsValueOptions)) {
            $classCheckboxOrRadio = ($type === 'radio') ? 'radio' : 'checkbox';

            $content = '<div class="' . $classCheckboxOrRadio . '">';
        }

        $element->setAttribute('id', $id);

        if (null !== $element->getOption('addon') || null !== $element->getOption('append') || null !== $element->getOption('prepend')) {
            $content .= '<div class="input-group">' . PHP_EOL;
        }

        $optionsPrepend = $element->getOptions();
        $optionsAppend = $element->getOptions();

        if (isset($optionsPrepend['prepend'])) {
            $optionsPrepend['addon'] = $optionsPrepend['prepend'];
        }
        if (isset($optionsAppend['append'])) {
            $optionsAppend['addon'] = $optionsAppend['append'];
        }

        $content .= $helperFormControlAddon($element->setOptions($optionsPrepend)) . PHP_EOL;
        $content .= $helperFormElement($element) . PHP_EOL;
        $content .= $helperFormControlAddon($element->setOptions($optionsAppend)) . PHP_EOL;

        if (in_array($type, $this->elementsValueOptions)) {
            $content = str_replace('/label><label', '/label></div><div class="' . $classCheckboxOrRadio . '"><label', $content);
            $content .= '</div>' . PHP_EOL;
        }

        if (null !== $element->getOption('append') || null !== $element->getOption('prepend')) {
            $content .= '</div>' . PHP_EOL;
        }

        if (count($element->getMessages()) > 0) {
            $options = $element->getOptions();

            $options['help-block'] = implode('<br />', $element->getMessages() );

            $element->setOptions($options);
        }

        $content .= $helperFormControlHelpBlock($element) . PHP_EOL;

        return $content;
    }

    /**
     * Retrieve the FormControlAddon helper
     *
     * @return FormControlAddon
     */
    protected function getHelperFormControlAddon()
    {
        if ($this->helperFormControlAddon) {
            return $this->helperFormControlAddon;
        }

        if (!$this->helperFormControlAddon instanceof FormControlAddon) {
            $this->helperFormControlAddon = new FormControlAddon();
        }

        $this->helperFormControlAddon->setView($this->getView());

        return $this->helperFormControlAddon;
    }

    /**
     * Retrieve the FormControlHelpBlock helper
     *
     * @return FormControlHelpBlock
     */
    protected function getHelperFormControlHelpBlock()
    {
        if ($this->helperFormControlHelpBlock) {
            return $this->helperFormControlHelpBlock;
        }

        if (!$this->helperFormControlHelpBlock instanceof FormControlHelpBlock) {
            $this->helperFormControlHelpBlock = new FormControlHelpBlock();
        }

        return $this->helperFormControlHelpBlock;
    }

    /**
     * Retrieve the FormElement helper
     *
     * @return FormElement
     */
    protected function getHelperFormElement()
    {
        if ($this->helperFormElement) {
            return $this->helperFormElement;
        }

        if (!$this->helperFormElement instanceof FormElement) {
            $this->helperFormElement = new FormElement();
        }

        $this->helperFormElement->setView($this->getView());

        return $this->helperFormElement;
    }
}
