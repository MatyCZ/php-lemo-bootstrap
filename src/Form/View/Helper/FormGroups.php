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
    public function __construct(
        protected ?FormGroupElement $helperFormGroupElement = null,
        protected ?FormGroupsCollection $helperFormGroupsCollection = null,
    ) {}

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

        $formGroupElement = $this->helperFormGroupElement;
        $formGroups = $this;
        $formGroupsCollection = $this->helperFormGroupsCollection;

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
}
