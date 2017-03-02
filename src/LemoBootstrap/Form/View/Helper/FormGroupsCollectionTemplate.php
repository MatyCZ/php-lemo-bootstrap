<?php

namespace LemoBootstrap\Form\View\Helper;

use Zend\Form\Element\Collection;
use Zend\Form\FieldsetInterface;

class FormGroupsCollectionTemplate extends AbstractHelper
{
    /**
     * @var FormControl
     */
    protected $helperFormControl;

    /**
     * @var FormGroupElement
     */
    protected $helperFormGroupElement;

    /**
     * @var string
     */
    protected $template = null;

    /**
     * @var string
     */
    protected $templatePlaceholderIndex = '__index__';

    /**
     * @var string
     */
    protected $templatePlaceholderOrder = '__order__';

    /**
     * @var array
     */
    protected $templatePlaceholdersElement = [];

    /**
     * @var array
     */
    protected $templatePlaceholdersElementGroups = [];

    /**
     * Invoke helper as function
     * Proxies to {@link render()}.
     *
     * @param  null|Collection $collection
     * @return string|FormGroupsCollectionTemplate
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
    public function render(Collection $collection)
    {
        $renderer = $this->getView();
        if (!method_exists($renderer, 'plugin')) {
            // Bail early if renderer is not pluggable
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
    public function renderTemplate(Collection $collection, $returnOnlyTemplateContent = false)
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
     * @param  string $template
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param  string $templatePlaceholderIndex
     * @return $this
     */
    public function setTemplatePlaceholderIndex($templatePlaceholderIndex)
    {
        $this->templatePlaceholderIndex = $templatePlaceholderIndex;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplatePlaceholderIndex()
    {
        return $this->templatePlaceholderIndex;
    }

    /**
     * @param  string $templatePlaceholderOrder
     * @return $this
     */
    public function setTemplatePlaceholderOrder($templatePlaceholderOrder)
    {
        $this->templatePlaceholderOrder = $templatePlaceholderOrder;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplatePlaceholderOrder()
    {
        return $this->templatePlaceholderOrder;
    }

    /**
     * @param  array $templatePlaceholdersElement
     * @return $this
     */
    public function setTemplatePlaceholdersElement($templatePlaceholdersElement)
    {
        $this->templatePlaceholdersElement = $templatePlaceholdersElement;

        return $this;
    }

    /**
     * @return array
     */
    public function getTemplatePlaceholdersElement()
    {
        return $this->templatePlaceholdersElement;
    }

    /**
     * @param  array $templatePlaceholdersElementGroups
     * @return $this
     */
    public function setTemplatePlaceholdersElementGroups($templatePlaceholdersElementGroups)
    {
        $this->templatePlaceholdersElementGroups = $templatePlaceholdersElementGroups;

        return $this;
    }

    /**
     * @return array
     */
    public function getTemplatePlaceholdersElementGroups()
    {
        return $this->templatePlaceholdersElementGroups;
    }

    /**
     * Retrieve the FormControl helper
     *
     * @return FormControl
     */
    protected function getHelperFormControl()
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
}
