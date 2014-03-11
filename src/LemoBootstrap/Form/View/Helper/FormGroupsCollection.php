<?php

namespace LemoBootstrap\Form\View\Helper;

use LemoBootstrap\Form\View\Helper\FormGroupElement;
use LemoBootstrap\Form\View\Helper\FormGroupElements;
use LemoBootstrap\Form\View\Helper\FormGroupsFieldset;
use Zend\Form\ElementInterface;
use Zend\Form\Element\Collection;
use Zend\Form\FieldsetInterface;
use Zend\Form\View\Helper\AbstractHelper;

class FormGroupsCollection extends AbstractHelper
{
    /**
     * @var FormGroupElement
     */
    protected $helperFormGroupElement;

    /**
     * @var FormGroupElements
     */
    protected $helperFormGroupElements;

    /**
     * @var FormGroupsFieldset
     */
    protected $helperFormGroupsFieldset;

    /**
     * Invoke helper as function
     *
     * Proxies to {@link render()}.
     *
     * @param  Collection|null $collection
     * @param  null|int        $size
     * @param  bool            $inline
     * @return string|FormGroupsCollection
     */
    public function __invoke(Collection $collection = null, $size = 12, $inline = false)
    {
        if (!$collection) {
            return $this;
        }

        return $this->render($collection, $size, $inline);
    }

    /**
     * Render a collection by iterating through all fieldsets and elements
     *
     * @param  Collection $collection
     * @param  null|int   $size
     * @param  bool       $inline
     * @return string
     */
    public function render(Collection $collection, $size = 12, $inline = false)
    {
        $renderer = $this->getView();
        if (!method_exists($renderer, 'plugin')) {
            // Bail early if renderer is not pluggable
            return '';
        }

        $helperFormGroupElement  = $this->getHelperFormGroupElement();
        $helperFormGroupElements  = $this->getHelperFormGroupElements();
        $helperFormGroupFieldset = $this->getHelperFormGroupsFieldset();

        // Render elements
        $markup = '';
        foreach ($collection->getIterator() as $elementOrFieldset) {
            if ($elementOrFieldset instanceof FieldsetInterface) {
                if (true === $inline) {
                    $markup .= $helperFormGroupElements($elementOrFieldset, $size);
                } else {
                    $markup .= $helperFormGroupFieldset($elementOrFieldset, $size);
                }
            } elseif ($elementOrFieldset instanceof ElementInterface) {
                $markup .= $helperFormGroupElement($elementOrFieldset, $size);
            }
        }

        // Render template
        if ($collection->shouldCreateTemplate()) {
            $markup .= $this->renderTemplate($collection, $size);
        }

        return $markup;
    }

    /**
     * Only render a template
     *
     * @param  Collection $collection
     * @param  null|int   $size
     * @param  bool       $inline
     * @return string
     */
    public function renderTemplate(Collection $collection, $size = 12, $inline = false)
    {
        $helperFormGroupElement = $this->getHelperFormGroupElement();
        $helperFormGroupElements = $this->getHelperFormGroupElements();
        $helperFormGroupsFieldset = $this->getHelperFormGroupsFieldset();

        $templateElement = $collection->getTemplateElement();

        $markup = '';
        if ($templateElement instanceof FieldsetInterface) {
            if (true === $inline) {
                $markup .= $helperFormGroupElements($templateElement, $size);
            } else {
                $markup .= $helperFormGroupsFieldset($templateElement, $size);
            }
        } elseif ($templateElement instanceof ElementInterface) {
            $markup .= $helperFormGroupElement($templateElement, $size);
        }

        $id = $this->getId($collection);
        $id = trim(strtr($id, array('[' => '-', ']' => '')), '-');

        $attributes = array(
            'id' => 'form-template-' . $id,
            'data-template' => $markup
        );

        $attributes = $this->prepareAttributes($attributes);

        return sprintf(
            '<span %s></span>',
            $this->createAttributesString($attributes)
        );
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

        $this->helperFormGroupElement->setView($this->getView());
        $this->helperFormGroupElement->setTranslator($this->getTranslator());

        return $this->helperFormGroupElement;
    }

    /**
     * Retrieve the FormGroupElements helper
     *
     * @return FormGroupElements
     */
    protected function getHelperFormGroupElements()
    {
        if ($this->helperFormGroupElements) {
            return $this->helperFormGroupElements;
        }

        if (!$this->helperFormGroupElements instanceof FormGroupElements) {
            $this->helperFormGroupElements = new FormGroupElements();
        }

        $this->helperFormGroupElements->setView($this->getView());
        $this->helperFormGroupElements->setTranslator($this->getTranslator());

        return $this->helperFormGroupElements;
    }

    /**
     * Retrieve the FormGroupsFieldset helper
     *
     * @return FormGroupsFieldset
     */
    protected function getHelperFormGroupsFieldset()
    {
        if ($this->helperFormGroupsFieldset) {
            return $this->helperFormGroupsFieldset;
        }

        if (!$this->helperFormGroupsFieldset instanceof FormGroupsFieldset) {
            $this->helperFormGroupsFieldset = new FormGroupsFieldset();
        }

        $this->helperFormGroupsFieldset->setView($this->getView());
        $this->helperFormGroupsFieldset->setTranslator($this->getTranslator());

        return $this->helperFormGroupsFieldset;
    }
}
