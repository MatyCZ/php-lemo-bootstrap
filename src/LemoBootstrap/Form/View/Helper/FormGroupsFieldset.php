<?php

namespace LemoBootstrap\Form\View\Helper;

use LemoBootstrap\Form\View\Helper\FormGroupElement;
use Zend\Form\ElementInterface;
use Zend\Form\FieldsetInterface;
use Zend\Form\View\Helper\AbstractHelper;

class FormGroupsFieldset extends AbstractHelper
{
    /**
     * @var FormGroupElement
     */
    protected $helperFormGroupElement;

    /**
     * Invoke helper as function
     * Proxies to {@link render()}.
     *
     * @param  FieldsetInterface|null $fieldset
     * @param  null|int              $size
     * @return string|FormGroupsFieldset
     */
    public function __invoke(FieldsetInterface $fieldset = null, $size = 12)
    {
        if (!$fieldset) {
            return $this;
        }

        return $this->render($fieldset, $size);
    }

    /**
     * Render a collection by iterating through all fieldsets and elements
     *
     * @param  FieldsetInterface $fieldset
     * @param  null|int         $size
     * @return string
     */
    public function render(FieldsetInterface $fieldset, $size = 12)
    {
        $renderer = $this->getView();
        if (!method_exists($renderer, 'plugin')) {
            // Bail early if renderer is not pluggable
            return '';
        }

        $helperFormGroupElement  = $this->getHelperFormGroupElement();
        $helperFormGroupFieldset = $this;

        $markup = '';
        foreach ($fieldset->getIterator() as $elementOrFieldset) {
            if ($elementOrFieldset instanceof FieldsetInterface) {
                $markup .= $helperFormGroupFieldset($elementOrFieldset, $size);
            } elseif ($elementOrFieldset instanceof ElementInterface) {
                $markup .= $helperFormGroupElement($elementOrFieldset, $size);
            }
        }

        return $markup;
    }

    /**
     * Retrieve the FormGroupElement helper
     *
     * @return FormGroupElement
     */
    protected function getHelperFormGroupElement()
    {
        if ($this->helperFormGroupElement) {
            return $this->helperFormGroupElement;
        }

        if (!$this->helperFormGroupElement instanceof FormGroupElement) {
            $this->helperFormGroupElement = new FormGroupElement();
        }

        $this->helperFormGroupElement->setView($this->getView());
        $this->helperFormGroupElement->setTranslator($this->getTranslator());

        return $this->helperFormGroupElement;
    }
}
