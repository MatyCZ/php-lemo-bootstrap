<?php

namespace LemoBootstrap\Form\View\Helper;

use LemoBootstrap\Exception;
use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\View\Helper\FormRow as FormRowHelper;

class FormRowElements extends AbstractHelper
{
    /**
     * @var FormRowHelper
     */
    protected $formRowHelper;

    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @param null|array|ElementInterface $elementOrElements
     * @param null|string           $labelPosition
     * @param bool                  $renderErrors
     * @return string|FormRow
     */
    public function __invoke($elementOrElements = null, $labelPosition = null, $renderErrors = null)
    {
        if (!$elementOrElements) {
            return $this;
        }

        if ($labelPosition !== null) {
            $this->getFormRowHelper()->setLabelPosition($labelPosition);
        }

        if ($renderErrors !== null){
            $this->getFormRowHelper()->setRenderErrors($renderErrors);
        }

        return $this->render($elementOrElements);
    }

    /**
     * Utility form helper that renders a label (if it exists), an element and errors
     *
     * @param  ElementInterface|array $elementOrElements
     * @return string
     */
    public function render($elementOrElements)
    {
        // Convert element to array
        if(!is_array($elementOrElements)) {
            $elementOrElements = array($elementOrElements);
        }

        $rowString = '';

        foreach($elementOrElements as $element) {
            if(!$element instanceof ElementInterface) {
                throw new Exception\InvalidArgumentException(sprintf(
                    '%s requires that $elementOrFieldset be an object implementing %s; received "%s"',
                    __METHOD__,
                    __NAMESPACE__ . '\ElementInterface',
                    (is_object($element) ? get_class($element) : gettype($element))
                ));
            }

            $rowString .= $this->getFormRowHelper()->render($element);
        }

        return $rowString;
    }

    /**
     * Retrieve the FormRow helper
     *
     * @return FormRowHelper
     */
    protected function getFormRowHelper()
    {
        if ($this->formRowHelper) {
            return $this->formRowHelper;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->formRowHelper = $this->view->plugin('form_row');
        }

        if (!$this->formRowHelper instanceof FormRowHelper) {
            $this->formRowHelper = new FormRowHelper();
        }

        return $this->formRowHelper;
    }
}
