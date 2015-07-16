<?php

namespace LemoBootstrap\Form\View\Helper;

use LemoBootstrap\Form\View\Helper\FormControlLabel;
use LemoBootstrap\Form\View\Helper\FormControls;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\Hidden;
use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\AbstractHelper;

class FormGroupElement extends AbstractHelper
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
     * @param  null|int      $size
     * @return string
     */
    public function __invoke(ElementInterface $element, $size = 12)
    {
        return $this->render($element, $size);
    }

    public function render(ElementInterface $element, $size = 12)
    {
        $helperLabel = $this->getHelperControlLabel();
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
            $markup .= $helperLabel($element, $sizeLabel);
        }

        // Add class to value options for multicheckbox and radio elements
        $classCheckbox = null;
        if ($element instanceof Checkbox) {
            $classCheckbox = ' checkbox';
        }

        $markup .= '<div class="col-md-' . $sizeElement . $classCheckbox . '">' . $helperControls($element) . '</div>';

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
     * Retrieve the FormControlLabel helper
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
