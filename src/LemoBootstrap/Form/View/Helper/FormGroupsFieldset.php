<?php

namespace LemoBootstrap\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\Element\Collection;
use Zend\Form\FieldsetInterface;

class FormGroupsFieldset extends AbstractHelper
{
    /**
     * @var FormGroupElement
     */
    protected $helperFormGroupElement;

    /**
     * @var FormGroupsCollection
     */
    protected $helperFormGroupsCollection;

    /**
     * Invoke helper as function
     * Proxies to {@link render()}.
     *
     * @param  FieldsetInterface|null $fieldset
     * @return string|FormGroupsFieldset
     */
    public function __invoke(FieldsetInterface $fieldset = null)
    {
        if (!$fieldset) {
            return $this;
        }

        return $this->render($fieldset);
    }

    /**
     * Render a collection by iterating through all fieldsets and elements
     *
     * @param  FieldsetInterface $fieldset
     * @param  null|int          $size
     * @return string
     */
    public function render(FieldsetInterface $fieldset)
    {
        $renderer = $this->getView();
        if (!method_exists($renderer, 'plugin')) {
            // Bail early if renderer is not pluggable
            return '';
        }

        $helperFormGroupElement  = $this->getHelperFormGroupElement();
        $helperFormGroupsCollection  = $this->getHelperFormGroupsCollection();
        $helperFormGroupFieldset = $this;

        $markup = '';
        foreach ($fieldset->getIterator() as $elementOrFieldset) {
            if ($elementOrFieldset instanceof Collection) {
                $markup .= $helperFormGroupsCollection($elementOrFieldset);
            } elseif ($elementOrFieldset instanceof FieldsetInterface) {
                $markup .= $helperFormGroupFieldset($elementOrFieldset);
            } elseif ($elementOrFieldset instanceof ElementInterface) {
                $markup .= $helperFormGroupElement($elementOrFieldset);
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

        $this->helperFormGroupElement->setTranslator($this->getTranslator());
        $this->helperFormGroupElement->setView($this->getView());

        return $this->helperFormGroupElement;
    }

    /**
     * Retrieve the FormGroupsCollection helper
     *
     * @return FormGroupsCollection
     */
    protected function getHelperFormGroupsCollection()
    {
        if ($this->helperFormGroupsCollection) {
            return $this->helperFormGroupsCollection;
        }

        if (!$this->helperFormGroupsCollection instanceof FormGroupsCollection) {
            $this->helperFormGroupsCollection = new FormGroupsCollection();
        }

        $this->helperFormGroupsCollection->setTranslator($this->getTranslator());
        $this->helperFormGroupsCollection->setView($this->getView());

        return $this->helperFormGroupsCollection;
    }
}
