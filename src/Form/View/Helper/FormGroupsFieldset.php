<?php

declare(strict_types=1);

namespace Lemo\Bootstrap\Form\View\Helper;

use Exception;
use Laminas\Form\Element\Collection;
use Laminas\Form\ElementInterface;
use Laminas\Form\FieldsetInterface;

class FormGroupsFieldset extends AbstractHelper
{
    protected ?FormGroupElement $formGroupElement = null;

    protected ?FormGroupsCollection $formGroupsCollection = null;

    /**
     * @throws Exception
     */
    public function __invoke(?FieldsetInterface $fieldset = null): self|string
    {
        if (!$fieldset instanceof FieldsetInterface) {
            return $this;
        }

        return $this->render($fieldset);
    }

    /**
     * @throws Exception
     */
    public function render(FieldsetInterface $fieldset): string
    {
        $helperFormGroupElement = $this->getFormGroupElement();
        $helperFormGroupsCollection = $this->getFormGroupsCollection();
        $formGroupsFieldset = $this;

        $markup = '';
        foreach ($fieldset->getIterator() as $elementOrFieldset) {
            if ($elementOrFieldset instanceof Collection) {
                $markup .= $helperFormGroupsCollection($elementOrFieldset);
            } elseif ($elementOrFieldset instanceof FieldsetInterface) {
                $markup .= $formGroupsFieldset($elementOrFieldset);
            } elseif ($elementOrFieldset instanceof ElementInterface) {
                $markup .= $helperFormGroupElement($elementOrFieldset);
            }
        }

        return $markup;
    }

    protected function getFormGroupElement(): FormGroupElement
    {
        if ($this->formGroupElement instanceof FormGroupElement) {
            return $this->formGroupElement;
        }

        $this->formGroupElement = new FormGroupElement();
        $this->formGroupElement->setTranslator($this->getTranslator());
        $this->formGroupElement->setView($this->getView());

        return $this->formGroupElement;
    }

    protected function getFormGroupsCollection(): FormGroupsCollection
    {
        if ($this->formGroupsCollection instanceof FormGroupsCollection) {
            return $this->formGroupsCollection;
        }

        $this->formGroupsCollection = new FormGroupsCollection();
        $this->formGroupsCollection->setTranslator($this->getTranslator());
        $this->formGroupsCollection->setView($this->getView());

        return $this->formGroupsCollection;
    }
}
