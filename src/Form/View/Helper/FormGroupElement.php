<?php

namespace Lemo\Bootstrap\Form\View\Helper;

use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\MultiCheckbox;
use Laminas\Form\Element\Radio;
use Laminas\Form\ElementInterface;

class FormGroupElement extends AbstractHelper
{
    protected ?FormControlLabel $helperControlLabel = null;
    protected ?FormControls $helperControls = null;
    protected string $templateCloseTag = '</div>';
    protected string $templateOpenTag = '<div class="form-group form-group-sm%s%s" id="form-group-%s">';

    /**
     * Display a Form
     *
     * @param  ElementInterface $element
     * @return string
     */
    public function __invoke(ElementInterface $element): string
    {
        return $this->render($element);
    }

    /**
     * @param ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element): string
    {
        $helperLabel = $this->getHelperControlLabel();
        $helperControls = $this->getHelperControls();

        $markup = '';
        if ('' != $element->getLabel()) {
            $markup .= $helperLabel($element);
        }

        // Add class to value options for multicheckbox and radio elements
        $classCheckbox = null;
        if ($element instanceof Checkbox && !$element instanceof MultiCheckbox) {
            $classCheckbox = ' checkbox';
        }

        $id = $this->getId($element);
        $id = trim(strtr($id, array('[' => '-', ']' => '')), '-');

        // Add ID to value options
        if ($element instanceof MultiCheckbox || $element instanceof Radio) {
            $valueOptions = [];
            foreach ($element->getValueOptions() as $value => $label) {
                if (!is_array($label)) {
                    $valueOptions[$value] = [
                        'value' => $value,
                        'label' => $label,
                        'attributes' => [
                            'id' => $id . '-' . $value,
                        ]
                    ];
                } else {
                    $valueOptions[$value] = $label;
                }
            }

            $element->setValueOptions($valueOptions);
        }

        $markup .= '<div class="col-md-' . $this->getSizeForElement() . $classCheckbox . '">' . $helperControls($element) . '</div>';

        return $this->openTag($element) . $markup . $this->closeTag();
    }

    /**
     * Generate an opening form tag
     *
     * @param  ElementInterface $element
     * @return string
     */
    public function openTag(ElementInterface $element): string
    {
        $id = $this->getId($element);
        $id = trim(strtr($id, array('[' => '-', ']' => '')), '-');

        $classHide = $element->getOption('hidden') ? ' hidden' : null;
        $classError = null;

        if ($element instanceof Hidden) {
            $classHide = ' hidden';
        }
        if (count($element->getMessages()) > 0) {
            $classError = ' has-error';
        }

        return sprintf(
            $this->templateOpenTag,
            $classHide,
            $classError,
            $id
        );
    }

    /**
     * Generate a closing form tag
     *
     * @return string
     */
    public function closeTag(): string
    {
        return $this->templateCloseTag;
    }

    /**
     * Retrieve the FormControlLabel helper
     *
     * @return FormControlLabel
     */
    protected function getHelperControlLabel(): FormControlLabel
    {
        if ($this->helperControlLabel) {
            return $this->helperControlLabel;
        }

        if (!$this->helperControlLabel instanceof FormControlLabel) {
            $this->helperControlLabel = new FormControlLabel();
        }

        $this->helperControlLabel->setTranslator($this->getTranslator());
        $this->helperControlLabel->setView($this->getView());

        return $this->helperControlLabel;
    }

    /**
     * Retrieve the FormControls helper
     *
     * @return FormControls
     */
    protected function getHelperControls(): FormControls
    {
        if ($this->helperControls) {
            return $this->helperControls;
        }

        if (!$this->helperControls instanceof FormControls) {
            $this->helperControls = new FormControls();
        }

        $this->helperControls->setTranslator($this->getTranslator());
        $this->helperControls->setView($this->getView());

        return $this->helperControls;
    }
}
