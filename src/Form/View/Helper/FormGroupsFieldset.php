<?php

namespace Lemo\Bootstrap\Form\View\Helper;

use Exception;
use Laminas\Form\Element\Collection;
use Laminas\Form\ElementInterface;
use Laminas\Form\FieldsetInterface;

class FormGroupsFieldset extends AbstractHelper
{
    protected ?FormGroupElement $helperFormGroupElement = null;
    protected ?FormGroupsCollection $helperFormGroupsCollection = null;

    /**
     * Invoke helper as function
     * Proxies to {@link render()}.
     *
     * @param FieldsetInterface|null $fieldset
     * @return string|self
     * @throws Exception
     */
    public function __invoke(?FieldsetInterface $fieldset = null)
    {
        if (!$fieldset) {
            return $this;
        }

        return $this->render($fieldset);
    }

    /**
     * Render a collection by iterating through all fieldsets and elements
     *
     * @param FieldsetInterface $fieldset
     * @return string
     * @throws Exception
     */
    public function render(FieldsetInterface $fieldset): string
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
    protected function getHelperFormGroupElement(): FormGroupElement
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
    protected function getHelperFormGroupsCollection(): FormGroupsCollection
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
