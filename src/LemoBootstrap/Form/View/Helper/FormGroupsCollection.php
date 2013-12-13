<?php

namespace LemoBootstrap\Form\View\Helper;

use LemoBootstrap\Form\View\Helper\FormGroupElement;
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
     * @return string|FormGroupsCollection
     */
    public function __invoke(Collection $collection = null, $size = 12)
    {
        if (!$collection) {
            return $this;
        }

        return $this->render($collection, $size);
    }

    /**
     * Render a collection by iterating through all fieldsets and elements
     *
     * @param  Collection $collection
     * @param  null|int   $size
     * @return string
     */
    public function render(Collection $collection, $size = 12)
    {
        $renderer = $this->getView();
        if (!method_exists($renderer, 'plugin')) {
            // Bail early if renderer is not pluggable
            return '';
        }

        $helperFormGroupElement  = $this->getHelperFormGroupElement();
        $helperFormGroupFieldset = $this->getHelperFormGroupsFieldset();

        // Render form group
        $markup = '';

        // Render elements
        foreach ($collection->getIterator() as $elementOrFieldset) {
            if ($elementOrFieldset instanceof FieldsetInterface) {
                $markup .= $helperFormGroupFieldset($elementOrFieldset, $size);
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
     * @return string
     */
    public function renderTemplate(Collection $collection, $size = 12)
    {
        $helperEscapeHtmlAttr = $this->getEscapeHtmlAttrHelper();
        $helperFormGroupElement = $this->getHelperFormGroupElement();
        $helperFormGroupsFieldset = $this->getHelperFormGroupsFieldset();

        $templateElement = $collection->getTemplateElement();

        $markup         = '';
        if ($templateElement instanceof FieldsetInterface) {
            $markup .= $helperFormGroupsFieldset($templateElement, $size);
        } elseif ($templateElement instanceof ElementInterface) {
            $markup .= $helperFormGroupElement($templateElement, $size);
        }

        return sprintf(
            '<span id="form-template-%s" data-template="%s"></span>',
            $collection->getName(),
            $helperEscapeHtmlAttr($markup)
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
