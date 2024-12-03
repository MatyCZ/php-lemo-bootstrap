<?php

declare(strict_types=1);

namespace Lemo\Bootstrap\Form\View\Helper;

use Exception;
use Laminas\Form\Element\Collection;
use Laminas\Form\ElementInterface;
use Laminas\Form\FieldsetInterface;

class FormGroupsFieldset extends AbstractHelper
{
    public function __construct(
        protected ?FormGroupElement $formGroupElement = null,
        protected ?FormGroupsCollection $formGroupsCollection = null,
    ) {}

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
        $helperFormGroupElement = $this->formGroupElement;
        $helperFormGroupsCollection = $this->formGroupsCollection;
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
}
