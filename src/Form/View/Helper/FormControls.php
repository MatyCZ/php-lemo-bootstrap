<?php

namespace Lemo\Bootstrap\Form\View\Helper;

use Laminas\Form\ElementInterface;

class FormControls extends AbstractHelper
{
    protected ?FormControl $helperFormControl = null;
    protected string $templateCloseTag = '';
    protected string $templateOpenTag = '';

    /**
     * Render form controls
     *
     * @param  ElementInterface|null $element
     * @return string|self
     */
    public function __invoke(?ElementInterface $element = null)
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
    public function render(ElementInterface $element): string
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
    public function openTag(ElementInterface $element): string
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
    public function closeTag(): string
    {
        return $this->templateCloseTag;
    }

    /**
     * Retrieve the FormControl helper
     *
     * @return FormControl
     */
    protected function getHelperFormControl(): FormControl
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
