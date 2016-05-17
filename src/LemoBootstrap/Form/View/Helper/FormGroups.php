<?php

namespace LemoBootstrap\Form\View\Helper;

use LemoBootstrap\Exception;
use Zend\Form\Element\Collection;
use Zend\Form\ElementInterface;
use Zend\Form\FieldsetInterface;
use Zend\Form\FormInterface;

class FormGroups extends AbstractHelper
{
    /**
     * @var FormGroupElement
     */
    protected $helperFormGroupElement;

    /**
     * @var FormGroupsCollection
     */
    protected $helperFormGroupsCollection;

    /**
     * @param  FormInterface|FieldsetInterface $formOrFieldset
     * @param  array                           $elementNames
     * @param  int                             $boxSize
     * @return string
     */
    public function __invoke($formOrFieldset, array $elementNames, $boxSize = null)
    {
        return $this->render($formOrFieldset, $elementNames, $boxSize);
    }

    /**
     * @param  FormInterface|FieldsetInterface $formOrFieldset
     * @param  array                           $elementNames
     * @param  int                             $boxSize
     * @return string
     */
    public function render($formOrFieldset, array $elementNames, $boxSize = null)
    {
        if (!$formOrFieldset instanceof FormInterface || !$formOrFieldset instanceof FieldsetInterface) {
            throw new Exception\InvalidArgumentException(sprintf("Argument must be instance of FormInterface or FieldsetInterface"));
        }

        // Set size of box
        if (null !== $boxSize) {
            $this->setSizeOfBox($boxSize);
        }

        $helperFormGroupElement     = $this->getHelperFormGroupElement();
        $helperFormGroupsCollection = $this->getHelperFormGroupsCollection();
        $helperFormGroupFieldset    = $this;

        $markup = '';
        foreach ($elementNames as $elementName) {
            if (!$formOrFieldset->has($elementName)) {
                continue;
            }

            $elementOrFieldset = $formOrFieldset->get($elementName);

            if ($elementOrFieldset instanceof Collection) {
                $markup .= $helperFormGroupsCollection($elementOrFieldset);
            } elseif ($elementOrFieldset instanceof FieldsetInterface) {
                $markup .= $helperFormGroupFieldset($elementOrFieldset);
            } elseif ($elementOrFieldset instanceof ElementInterface) {
                $markup .= $helperFormGroupElement($elementOrFieldset);
            }
        }

        return $markup;
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

    /**
     * Retrieve the FormGroupsCollection helper
     *
     * @return FormGroupsCollection
     */
    protected function getHelperFormGroupsCollection()
    {
        if ($this->helperFormGroupsCollection) {
            return $this->helperFormGroupsCollection;
        }

        if (!$this->helperFormGroupsCollection instanceof FormGroupsCollection) {
            $this->helperFormGroupsCollection = new FormGroupsCollection();
        }

        $this->helperFormGroupsCollection->setTranslator($this->getTranslator());
        $this->helperFormGroupsCollection->setView($this->getView());

        return $this->helperFormGroupsCollection;
    }
}
