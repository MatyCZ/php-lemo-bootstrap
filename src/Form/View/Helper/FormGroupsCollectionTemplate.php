<?php

declare(strict_types=1);

namespace Lemo\Bootstrap\Form\View\Helper;

use Laminas\Form\Element\Collection;
use Laminas\Form\FieldsetInterface;

use function sprintf;
use function str_replace;
use function strtr;
use function trim;

class FormGroupsCollectionTemplate extends AbstractHelper
{
    protected ?FormControl $formControl = null;

    protected ?FormGroupElement $formGroupElement = null;

    protected ?string $template = null;

    protected string $templatePlaceholderIndex = '__index__';

    protected string $templatePlaceholderOrder = '__order__';

    protected array $templatePlaceholdersElement = [];

    protected array $templatePlaceholdersElementGroups = [];

    public function __invoke(?Collection $collection = null): self|string
    {
        if (!$collection instanceof Collection) {
            return $this;
        }

        return $this->render($collection);
    }

    public function render(Collection $collection): string
    {
        $formControl = $this->getFormControl();
        $formGroupElement = $this->getFormGroupElement();

        $markup = '';
        foreach ($collection->getIterator() as $index => $elementOrFieldset) {
            if ($elementOrFieldset instanceof FieldsetInterface) {
                $template = $this->getTemplate();

                // Render only element
                foreach ($this->templatePlaceholdersElement as $placeholder => $elementName) {
                    if ($elementOrFieldset->has($elementName)) {
                        $template = str_replace(
                            $placeholder,
                            $formControl($elementOrFieldset->get($elementName)),
                            $template,
                        );
                    }
                }

                // Render element groups
                foreach ($this->templatePlaceholdersElementGroups as $placeholder => $elementName) {
                    if ($elementOrFieldset->has($elementName)) {
                        $template = str_replace(
                            $placeholder,
                            $formGroupElement($elementOrFieldset->get($elementName)),
                            $template,
                        );
                    }
                }

                // Render index
                $template = str_replace(
                    $this->templatePlaceholderIndex,
                    (string) $index,
                    $template,
                );

                // Render order
                $template = str_replace(
                    $this->templatePlaceholderOrder,
                    (string) ($index + 1),
                    $template,
                );

                $markup .= $template;
            }
        }

        // Render template
        if ($collection->shouldCreateTemplate()) {
            $markup .= $this->renderTemplate($collection);
        }

        return $markup;
    }

    /**
     * Only render a template
     */
    public function renderTemplate(Collection $collection, bool $returnOnlyTemplateContent = false): string
    {
        $formControl = $this->getFormControl();
        $formGroupElement = $this->getFormGroupElement();

        $template = $this->getTemplate();
        $templateElement = $collection->getTemplateElement();

        // Render only element
        foreach ($this->getTemplatePlaceholdersElement() as $placeholder => $elementName) {
            if ($templateElement->has($elementName)) {
                $template = str_replace(
                    $placeholder,
                    $formControl($templateElement->get($elementName)),
                    $template,
                );
            }
        }

        // Render element groups
        foreach ($this->getTemplatePlaceholdersElementGroups() as $placeholder => $elementName) {
            if ($templateElement->has($elementName)) {
                $template = str_replace(
                    $placeholder,
                    $formGroupElement($templateElement->get($elementName)),
                    $template,
                );
            }
        }

        if ($returnOnlyTemplateContent) {
            return $template;
        }

        $id = $this->getId($collection);
        $id = trim(strtr($id, ['[' => '-', ']' => '']), '-');

        $attributes = [
            'id'            => 'form-template-' . $id,
            'data-template' => $template,
        ];

        $attributes = $this->prepareAttributes($attributes);

        return sprintf(
            '<span %s></span>',
            $this->createAttributesString($attributes),
        );
    }

    public function setTemplate(?string $template = null): self
    {
        $this->template = $template;

        return $this;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplatePlaceholderIndex(string $templatePlaceholderIndex): self
    {
        $this->templatePlaceholderIndex = $templatePlaceholderIndex;

        return $this;
    }

    public function getTemplatePlaceholderIndex(): string
    {
        return $this->templatePlaceholderIndex;
    }

    public function setTemplatePlaceholderOrder(string $templatePlaceholderOrder): self
    {
        $this->templatePlaceholderOrder = $templatePlaceholderOrder;

        return $this;
    }

    public function getTemplatePlaceholderOrder(): string
    {
        return $this->templatePlaceholderOrder;
    }

    public function setTemplatePlaceholdersElement(array $templatePlaceholdersElement): self
    {
        $this->templatePlaceholdersElement = $templatePlaceholdersElement;

        return $this;
    }

    public function getTemplatePlaceholdersElement(): array
    {
        return $this->templatePlaceholdersElement;
    }

    public function setTemplatePlaceholdersElementGroups(array $templatePlaceholdersElementGroups): self
    {
        $this->templatePlaceholdersElementGroups = $templatePlaceholdersElementGroups;

        return $this;
    }

    public function getTemplatePlaceholdersElementGroups(): array
    {
        return $this->templatePlaceholdersElementGroups;
    }

    protected function getFormControl(): FormControl
    {
        if ($this->formControl instanceof FormControl) {
            return $this->formControl;
        }

        $this->formControl = new FormControl();
        $this->formControl->setTranslator($this->getTranslator());
        $this->formControl->setView($this->getView());

        return $this->formControl;
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
}
