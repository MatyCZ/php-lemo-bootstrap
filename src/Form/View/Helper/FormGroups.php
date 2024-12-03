<?php

declare(strict_types=1);

namespace Lemo\Bootstrap\Form\View\Helper;

use Exception;
use Laminas\Form\Element\Collection;
use Laminas\Form\ElementInterface;
use Laminas\Form\FieldsetInterface;
use Laminas\Form\FormInterface;

class FormGroups extends AbstractHelper
{
    protected ?FormGroupElement $formGroupElement = null;

    protected ?FormGroupsCollection $formGroupsCollection = null;

    /**
     * @throws Exception
     */
    public function __invoke(
        FormInterface|FieldsetInterface $formOrFieldset,
        array $elementNames,
        ?int $boxSize = null,
    ): string {
        return $this->render($formOrFieldset, $elementNames, $boxSize);
    }

    /**
     * @throws Exception
     */
    public function render(
        FormInterface|FieldsetInterface $formOrFieldset,
        array $elementNames,
        ?int $boxSize = null,
    ): string {
        if (null !== $boxSize) {
            $this->setSizeOfBox($boxSize);
        }

        $formGroupElement = $this->getFormGroupElement();
        $formGroups = $this;
        $formGroupsCollection = $this->getFormGroupsCollection();

        $markup = '';
        foreach ($elementNames as $elementName) {
            if (!$formOrFieldset->has($elementName)) {
                continue;
            }

            $elementOrFieldset = $formOrFieldset->get($elementName);

            if ($elementOrFieldset instanceof Collection) {
                $markup .= $formGroupsCollection($elementOrFieldset);
            } elseif ($elementOrFieldset instanceof FieldsetInterface) {
                $markup .= $formGroups($elementOrFieldset);
            } elseif ($elementOrFieldset instanceof ElementInterface) {
                $markup .= $formGroupElement($elementOrFieldset);
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
