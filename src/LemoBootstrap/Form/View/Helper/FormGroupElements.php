<?php

namespace LemoBootstrap\Form\View\Helper;

use LemoBootstrap\Form\View\Helper\FormControlLabel;
use LemoBootstrap\Form\View\Helper\FormControls;
use Zend\Form\Element\Hidden;
use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\AbstractHelper;

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
     * @param  null|int         $size
     * @return string
     */
    public function __invoke(ElementInterface $element, $size = 12)
    {
        return $this->render($element, $size);
    }

    public function render(ElementInterface $element, $size = 12)
    {
        $helperControlLabel = $this->getHelperControlLabel();
        $helperControls = $this->getHelperControls();

        if ($size == 12) {
            $sizeLabel = 2;
            $sizeElement = 10;
        } else {
            $sizeLabel = 4;
            $sizeElement = 8;
        }

        $markup = '';
        if ('' != $element->getLabel()) {
            $markup .= $helperControlLabel($element, $sizeLabel);
        }

        $markup .= '<div class="col-lg-' . $sizeElement . '">';
        foreach ($element->getElements() as $el) {
            $markup .= $helperControls($el) . PHP_EOL;
        }
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
        $id = $element->getAttribute('id') ? : $element->getName();
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

        $this->helperControlLabel->setView($this->getView());
        $this->helperControlLabel->setTranslator($this->getTranslator());

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

        $this->helperControls->setView($this->getView());
        $this->helperControls->setTranslator($this->getTranslator());

        return $this->helperControls;
    }
}