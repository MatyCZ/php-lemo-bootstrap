<?php

namespace Lemo\Bootstrap\Form\View\Helper;

use Laminas\Form\Element\Collection;
use Laminas\Form\FieldsetInterface;

class FormGroupsCollectionTemplate extends AbstractHelper
{
    protected ?FormControl $helperFormControl = null;
    protected ?FormGroupElement $helperFormGroupElement = null;
    protected ?string $template = null;
    protected string $templatePlaceholderIndex = '__index__';
    protected string $templatePlaceholderOrder = '__order__';
    protected array $templatePlaceholdersElement = [];
    protected array $templatePlaceholdersElementGroups = [];

    /**
     * Invoke helper as function
     * Proxies to {@link render()}.
     *
     * @param  Collection|null $collection
     * @return string|self
     */
    public function __invoke(Collection $collection = null)
    {
        if (null === $collection) {
            return $this;
        }

        return $this->render($collection);
    }

    /**
     * Render a collection by iterating through all fieldsets and elements
     *
     * @param  Collection $collection
     * @return string
     */
    public function render(Collection $collection): string
    {
        $renderer = $this->getView();

        if (!method_exists($renderer, 'plugin')) {
            return '';
        }

        $helperFormControl       = $this->getHelperFormControl();
        $helperFormGroupElement  = $this->getHelperFormGroupElement();

        $markup = '';
        foreach ($collection->getIterator() as $index => $elementOrFieldset) {
            if ($elementOrFieldset instanceof FieldsetInterface) {
                $template = $this->getTemplate();

                // Render only element
                foreach ($this->templatePlaceholdersElement as $placeholder => $elementName) {
                    if ($elementOrFieldset->has($elementName)) {
                        $template = str_replace($placeholder, $helperFormControl($elementOrFieldset->get($elementName)), $template);
                    }
                }

                // Render element groups
                foreach ($this->templatePlaceholdersElementGroups as $placeholder => $elementName) {
                    if ($elementOrFieldset->has($elementName)) {
                        $template = str_replace($placeholder, $helperFormGroupElement($elementOrFieldset->get($elementName)), $template);
                    }
                }

                // Render index
                $template = str_replace($this->templatePlaceholderIndex, $index, $template);

                // Render order
                $template = str_replace($this->templatePlaceholderOrder, $index+1, $template);

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
     *
     * @param  Collection $collection
     * @param  bool       $returnOnlyTemplateContent
     * @return string
     */
    public function renderTemplate(Collection $collection, bool $returnOnlyTemplateContent = false): string
    {
        $helperFormControl       = $this->getHelperFormControl();
        $helperFormGroupElement  = $this->getHelperFormGroupElement();

        $template = $this->getTemplate();
        $templateElement = $collection->getTemplateElement();

        // Render only element
        foreach ($this->getTemplatePlaceholdersElement() as $placeholder => $elementName) {
            if ($templateElement->has($elementName)) {
                $template = str_replace($placeholder, $helperFormControl($templateElement->get($elementName)), $template);
            }
        }

        // Render element groups
        foreach ($this->getTemplatePlaceholdersElementGroups() as $placeholder => $elementName) {
            if ($templateElement->has($elementName)) {
                $template = str_replace($placeholder, $helperFormGroupElement($templateElement->get($elementName)), $template);
            }
        }

        if (true === $returnOnlyTemplateContent) {
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
            $this->createAttributesString($attributes)
        );
    }

    /**
     * @param  string|null $template
     * @return self
     */
    public function setTemplate(?string $template): self
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTemplate(): ?string
    {
        return $this->template;
    }

    /**
     * @param  string $templatePlaceholderIndex
     * @return self
     */
    public function setTemplatePlaceholderIndex(string $templatePlaceholderIndex): self
    {
        $this->templatePlaceholderIndex = $templatePlaceholderIndex;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplatePlaceholderIndex(): string
    {
        return $this->templatePlaceholderIndex;
    }

    /**
     * @param  string $templatePlaceholderOrder
     * @return self
     */
    public function setTemplatePlaceholderOrder(string $templatePlaceholderOrder): self
    {
        $this->templatePlaceholderOrder = $templatePlaceholderOrder;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplatePlaceholderOrder(): string
    {
        return $this->templatePlaceholderOrder;
    }

    /**
     * @param  array $templatePlaceholdersElement
     * @return self
     */
    public function setTemplatePlaceholdersElement(array $templatePlaceholdersElement): self
    {
        $this->templatePlaceholdersElement = $templatePlaceholdersElement;

        return $this;
    }

    /**
     * @return array
     */
    public function getTemplatePlaceholdersElement(): array
    {
        return $this->templatePlaceholdersElement;
    }

    /**
     * @param  array $templatePlaceholdersElementGroups
     * @return self
     */
    public function setTemplatePlaceholdersElementGroups(array $templatePlaceholdersElementGroups): self
    {
        $this->templatePlaceholdersElementGroups = $templatePlaceholdersElementGroups;

        return $this;
    }

    /**
     * @return array
     */
    public function getTemplatePlaceholdersElementGroups(): array
    {
        return $this->templatePlaceholdersElementGroups;
    }

    /**
     * Retrieve the FormControl helper
     *
     * @return FormControl
     */
    protected function getHelperFormControl(): FormControl
    {
        if ($this->helperFormControl) {
            return $this->helperFormControl;
        }

        if (!$this->helperFormControl instanceof FormControl) {
            $this->helperFormControl = new FormControl();
        }

        $this->helperFormControl->setTranslator($this->getTranslator());
        $this->helperFormControl->setView($this->getView());

        return $this->helperFormControl;
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
}
