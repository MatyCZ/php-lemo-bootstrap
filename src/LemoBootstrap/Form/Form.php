<?php

namespace LemoBootstrap\Form;

use Zend\Form\ElementInterface;
use Zend\Form\FieldsetInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterProviderInterface;

class Form extends \Zend\Form\Form
{
    /**
     * @inheritdoc
     */
    public function prepare()
    {
        parent::prepare();

        // Set Form attributes
        $this->setAttribute('novalidate', true);

        // Execute specific Form functions
        $this->appendAttributeRequired($this, $this->getInputFilter());

        return $this;
    }

    /**
     * @param  FieldsetInterface    $formOrFieldset
     * @param  InputFilterInterface $inputFilter
     * @return $this
     */
    protected function appendAttributeRequired(FieldsetInterface $formOrFieldset, InputFilterInterface $inputFilter = null)
    {
        /**
         * @var FieldsetInterface $fieldset
         */
        foreach ($formOrFieldset->getFieldsets() as $fieldsetName => $fieldset) {

            // Exists InputFilter for fieldset?
            $fieldsetInputFilter = null;
            if ($inputFilter instanceof InputFilterInterface && $inputFilter->has($fieldsetName) && $inputFilter->get($fieldsetName) instanceof InputFilterInterface) {
                $fieldsetInputFilter = $inputFilter->get($fieldsetName);
            }

            $this->appendAttributeRequired($fieldset, $fieldsetInputFilter);
        }

        /**
         * @var ElementInterface $element
         */
        foreach ($formOrFieldset->getElements() as $elementName => $element) {
            if ($inputFilter instanceof InputFilterInterface) {
                if ($inputFilter->has($elementName) && $inputFilter->get($elementName)->isRequired()) {
                    $element->setAttribute('required', true);
                }
            } elseif ($formOrFieldset instanceOf InputFilterProviderInterface) {
                $spec = $formOrFieldset->getInputFilterSpecification();

                if (!empty($spec[$elementName]['required'])) {
                    $element->setAttribute('required', true);
                }
            }
        }

        return $this;
    }
}