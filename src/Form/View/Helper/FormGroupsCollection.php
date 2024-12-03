<?php

declare(strict_types=1);

namespace Lemo\Bootstrap\Form\View\Helper;

use Exception;
use Laminas\Form\Element\Collection;
use Laminas\Form\ElementInterface;
use Laminas\Form\FieldsetInterface;

use function sprintf;
use function strtr;
use function trim;

class FormGroupsCollection extends AbstractHelper
{
    public function __construct(
        protected ?FormGroupElement $formGroupElement = null,
        protected ?FormGroupElements $formGroupElements = null,
        protected ?FormGroupsFieldset $formGroupsFieldset = null,
    ) {}

    /**
     * @throws Exception
     */
    public function __invoke(Collection $collection = null, bool $inline = false): self|string
    {
        if (!$collection instanceof Collection) {
            return $this;
        }

        return $this->render($collection, $inline);
    }

    /**
     * @throws Exception
     */
    public function render(Collection $collection, bool $inline = false): string
    {
        $formGroupElement = $this->formGroupElement;
        $formGroupElements = $this->formGroupElements;
        $formGroupsFieldset = $this->formGroupsFieldset;

        // Render elements
        $markup = '';
        foreach ($collection->getIterator() as $elementOrFieldset) {
            if ($elementOrFieldset instanceof FieldsetInterface) {
                if ($inline) {
                    $markup .= $formGroupElements($elementOrFieldset);
                } else {
                    $markup .= $formGroupsFieldset($elementOrFieldset);
                }
            } elseif ($elementOrFieldset instanceof ElementInterface) {
                $markup .= $formGroupElement($elementOrFieldset);
            }
        }

        // Render template
        if ($collection->shouldCreateTemplate()) {
            $markup .= $this->renderTemplate($collection);
        }

        return $markup;
    }

    /**
     * @throws Exception
     */
    public function renderTemplate(
        Collection $collection,
        bool $inline = false,
        bool $returnOnlyTemplateContent = false,
    ): string {
        $formGroupElement = $this->formGroupElement;
        $formGroupElements = $this->formGroupElements;
        $formGroupsFieldset = $this->formGroupsFieldset;

        $templateElement = $collection->getTemplateElement();

        $markup = '';
        if ($templateElement instanceof FieldsetInterface) {
            if ($inline) {
                $markup .= $formGroupElements($templateElement);
            } else {
                $markup .= $formGroupsFieldset($templateElement);
            }
        } elseif ($templateElement instanceof ElementInterface) {
            $markup .= $formGroupElement($templateElement);
        }

        if ($returnOnlyTemplateContent) {
            return $markup;
        }

        $id = $this->getId($collection);
        $id = trim(strtr($id, ['[' => '-', ']' => '']), '-');

        $attributes = ['id' => 'form-template-' . $id, 'data-template' => $markup];

        $attributes = $this->prepareAttributes($attributes);

        return sprintf(
            '<span %s></span>',
            $this->createAttributesString($attributes),
        );
    }
}
