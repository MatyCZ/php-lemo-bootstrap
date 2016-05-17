<?php

namespace LemoBootstrap\Form\View\Helper;

use Zend\Form\Element\Collection;
use Zend\Form\FieldsetInterface;

class FormTemplateCollection extends AbstractHelper
{
    /**
     * @var FormControl
     */
    protected $helperFormControl;

    /**
     * @var string
     */
    protected $template = null;

    /**
     * @var array
     */
    protected $templatePlaceholders = array();

    /**
     * Invoke helper as function
     *
     * Proxies to {@link render()}.
     *
     * @param  null|Collection $collection
     * @return string|FormGroupsCollection
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

        $helperFormControl  = $this->getHelperFormControl();

        $markup = '';
        foreach ($collection->getIterator() as $elementOrFieldset) {
            if ($elementOrFieldset instanceof FieldsetInterface) {
                $template = $this->getTemplate();

                foreach ($this->getTemplatePlaceholders() as $placeholder => $elementName) {
                    if ($elementOrFieldset->has($elementName)) {
                        $template = str_replace($placeholder, $helperFormControl($elementOrFieldset->get($elementName)), $template);
                    }
                }

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
     * @return string
     */
    public function renderTemplate(Collection $collection)
    {
        $helperFormControl  = $this->getHelperFormControl();
        $templateElement = $collection->getTemplateElement();

        $template = $this->getTemplate();
        foreach ($this->getTemplatePlaceholders() as $placeholder => $elementName) {
            if ($templateElement->has($elementName)) {
                $template = str_replace($placeholder, $helperFormControl($templateElement->get($elementName)), $template);
            }
        }

        $id = $this->getId($collection);
        $id = trim(strtr($id, array('[' => '-', ']' => '')), '-');

        $attributes = array(
            'id' => 'form-template-' . $id,
            'data-template' => $template
        );

        $attributes = $this->prepareAttributes($attributes);

        return sprintf(
            '<span %s></span>',
            $this->createAttributesString($attributes)
        );
    }

    /**
     * @param  string $template
     * @return self
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
     * @param  array $templatePlaceholders
     * @return self
     */
    public function setTemplatePlaceholders($templatePlaceholders)
    {
        $this->templatePlaceholders = $templatePlaceholders;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplatePlaceholders()
    {
        return $this->templatePlaceholders;
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
}
