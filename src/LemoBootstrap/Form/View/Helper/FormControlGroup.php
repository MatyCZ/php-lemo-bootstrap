<?php

namespace LemoBootstrap\Form\View\Helper;

use LemoBootstrap\Form\View\Helper\FormControlLabel;
use LemoBootstrap\Form\View\Helper\FormControls;
use Zend\Form\ElementInterface;
use Zend\Form\FieldsetInterface;
use Zend\Form\View\Helper\AbstractHelper;

class FormControlGroup extends AbstractHelper
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
     * @param  null|string   $formStyle
     * @return string
     */
    public function __invoke(ElementInterface $element, $formStyle = null)
    {
        return $this->render($element);
    }

    public function render(ElementInterface $element)
    {
        $helperLabel = $this->getHelperControlLabel();
        $helperControls = $this->getHelperControls();

        $content = '';
        if ($element instanceof FieldsetInterface) {
            $first = $element->getIterator()->top();

            if ('' != $first->getLabel()) {
                $content .= $helperLabel($first);
            }
        } else {
            if ('' != $element->getLabel()) {
                $content .= $helperLabel($element);
            }
        }

        $content .= '<div class="col-lg-8">' . $helperControls($element) . '</div>';

        return $this->openTag($element) . $content . $this->closeTag();
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
        $classHide = $element->getOption('hide') ? ' hide' : null;
        $classError = null;

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

    /**
     * Retrieve the FormLabel helper
     *
     * @return FormLabel
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
}
