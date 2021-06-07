<?php

namespace Lemo\Bootstrap\Form\View\Helper;

use Laminas\Form\Element\Hidden;
use Laminas\Form\ElementInterface;

class FormGroupElements extends AbstractHelper
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
        $helperControlLabel = $this->getHelperControlLabel();
        $helperControls = $this->getHelperControls();

        $markup = '';
        if ('' != $element->getLabel()) {
            $markup .= $helperControlLabel($element);
        }

        $markup .= '<div class="col-md-' . $this->getSizeForElement() . '">';
        $markup .= '    <div class="row">';
        foreach ($element->getElements() as $el) {
            $markup .= '    <div class="col-md-' . round(12 / count($element->getElements())) . '">';
            $markup .= '        ' . $helperControls($el) . PHP_EOL;
            $markup .= '    </div>';
        }
        $markup .= '    </div>';
        $markup .= '</div>';

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
     * Retrieve the FormLabel helper
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
