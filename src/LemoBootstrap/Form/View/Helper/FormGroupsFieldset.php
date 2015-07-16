<?php

namespace LemoBootstrap\Form\View\Helper;

use LemoBootstrap\Form\View\Helper\FormGroupElement;
use LemoBootstrap\Form\View\Helper\FormGroupsCollection;
use Zend\Form\ElementInterface;
use Zend\Form\Element\Collection;
use Zend\Form\FieldsetInterface;
use Zend\Form\View\Helper\AbstractHelper;

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
        $helperFormGroupsCollection  = $this->getHelperFormGroupsCollection();
        $helperFormGroupFieldset = $this;

        $markup = '';
        foreach ($fieldset->getIterator() as $elementOrFieldset) {
            if ($elementOrFieldset instanceof Collection) {
                $markup .= $helperFormGroupsCollection($elementOrFieldset, $size);
            } elseif ($elementOrFieldset instanceof FieldsetInterface) {
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
