<?php

namespace LemoBootstrap\Form\View\Helper;

use LemoBootstrap\Form\View\Helper\FormControl;
use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\AbstractHelper;

class FormControls extends AbstractHelper
{
    /**
     * @var FormControl
     */
    protected $helperFormControl;

    /**
     * @var string
     */
    protected $templateCloseTag = '';

    /**
     * @var string
     */
    protected $templateOpenTag = '';

    /**
     * Render form controls
     *
     * @param  null|ElementInterface $element
     * @return string
     */
    public function __invoke(ElementInterface $element = null)
    {
        if (null === $element) {
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
        $helperFormControl = $this->getHelperFormControl();

        $content = '';

        if (is_array($element) || $element instanceof \Traversable) {
            foreach ($element as $el) {
                $content .= $helperFormControl($el) . PHP_EOL;
            }
        } else {
            $content .= $helperFormControl($element) . PHP_EOL;
        }

        return $this->openTag($element) . $content . $this->closeTag();
    }

    /**
     * Generate an opening tag
     *
     * @param  ElementInterface $element
     * @return string
     */
    public function openTag(ElementInterface $element)
    {
        $id = $this->getId($element);
        $id = trim(strtr($id, array('[' => '-', ']' => '')), '-');

        return sprintf(
            $this->templateOpenTag,
            $id
        );
    }

    /**
     * Generate a closing tag
     *
     * @return string
     */
    public function closeTag()
    {
        return $this->templateCloseTag;
    }

    /**
     * Retrieve the FormControl helper
     *
     * @return FormControl
     */
    protected function getHelperFormControl()
    {
        if ($this->helperFormControl) {
            return $this->helperFormControl;
        }

        if (!$this->helperFormControl instanceof FormControl) {
            $this->helperFormControl = new FormControl();
        }

        $this->helperFormControl->setTranslator($this->getTranslator());
        $this->helperFormControl->setView($this->getView());

        return $this->helperFormControl;
    }
}
