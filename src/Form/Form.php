<?php

declare(strict_types=1);

namespace Lemo\Bootstrap\Form;

use Laminas\Form\FieldsetInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\InputFilter\InputFilterProviderInterface;

class Form extends \Laminas\Form\Form
{
    /**
     * @inheritdoc
     */
    #[\Override]
    public function prepare(): self
    {
        parent::prepare();

        // Set Form attributes
        $this->setAttribute('novalidate', true);

        // Execute specific Form functions
        $this->appendAttributeRequired($this, $this->getInputFilter());

        return $this;
    }

    protected function appendAttributeRequired(
        FieldsetInterface $formOrFieldset,
        ?InputFilterInterface $inputFilter = null,
    ): self {
        foreach ($formOrFieldset->getFieldsets() as $fieldsetName => $fieldset) {

            // Exists InputFilter for fieldset?
            $fieldsetInputFilter = null;
            if ($inputFilter instanceof InputFilterInterface && $inputFilter->has($fieldsetName) && $inputFilter->get($fieldsetName) instanceof InputFilterInterface) {
                $fieldsetInputFilter = $inputFilter->get($fieldsetName);
            }

            $this->appendAttributeRequired($fieldset, $fieldsetInputFilter);
        }

        foreach ($formOrFieldset->getElements() as $elementName => $element) {
            if ($inputFilter instanceof InputFilterInterface) {
                if ($inputFilter->has($elementName) && $inputFilter->get($elementName)->isRequired()) {
                    $element->setAttribute('required', true);
                }
            } elseif ($formOrFieldset instanceof InputFilterProviderInterface) {
                $spec = $formOrFieldset->getInputFilterSpecification();

                if (!empty($spec[$elementName]['required'])) {
                    $element->setAttribute('required', true);
                }
            }
        }

        return $this;
    }
}
