<?php

namespace LemoBootstrap\Form\View\Helper;

use Zend\Form\Element\Hidden;
use Zend\Form\ElementInterface;

class FormGroupElements extends AbstractHelper
{
    /**
     * @var FormControlLabel
     */
    protected $helperControlLabel;

    /**
     * @var FormControls
     */
    protected $helperControls;

    /**
     * @var string
     */
    protected $templateCloseTag = '</div>';

    /**
     * @var string
     */
    protected $templateOpenTag = '<div class="form-group%s%s" id="form-group-%s">';

    /**
     * Display a Form
     *
     * @param  ElementInterface $element
     * @return string
     */
    public function __invoke(ElementInterface $element)
    {
        return $this->render($element);
    }

    public function render(ElementInterface $element)
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
    public function openTag(ElementInterface $element)
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
    public function closeTag()
    {
        return $this->templateCloseTag;
    }

    /**
     * Retrieve the FormLabel helper
     *
     * @return FormControlLabel
     */
    protected function getHelperControlLabel()
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
    protected function getHelperControls()
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
