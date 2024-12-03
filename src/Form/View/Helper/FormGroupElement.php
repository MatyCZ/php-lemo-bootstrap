<?php

declare(strict_types=1);

namespace Lemo\Bootstrap\Form\View\Helper;

use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\MultiCheckbox;
use Laminas\Form\Element\Radio;
use Laminas\Form\ElementInterface;

use function is_array;
use function sprintf;
use function strtr;
use function trim;

class FormGroupElement extends AbstractHelper
{
    protected ?FormControlLabel $formControlLabel = null;

    protected ?FormControls $formControls = null;

    protected string $templateCloseTag = '</div>';

    protected string $templateOpenTag = '<div class="form-group form-group-sm%s%s" id="form-group-%s">';

    public function __invoke(ElementInterface $element): string
    {
        return $this->render($element);
    }

    public function render(ElementInterface $element): string
    {
        $formControlLabel = $this->getFormControlLabel();
        $formControls = $this->getFormControls();

        $markup = '';
        if ('' != $element->getLabel()) {
            $markup .= $formControlLabel($element);
        }

        // Add class to value options for multicheckbox and radio elements
        $classCheckbox = null;
        if ($element instanceof Checkbox && !$element instanceof MultiCheckbox) {
            $classCheckbox = ' checkbox';
        }

        $id = $this->getId($element);
        $id = trim(strtr($id, ['[' => '-', ']' => '']), '-');

        // Add ID to value options
        if ($element instanceof MultiCheckbox || $element instanceof Radio) {
            $valueOptions = [];
            foreach ($element->getValueOptions() as $value => $label) {
                if (!is_array($label)) {
                    $valueOptions[$value] = [
                        'value' => $value,
                        'label' => $label,
                        'attributes' => [
                            'id' => $id . '-' . $value,
                        ],
                    ];
                } else {
                    $valueOptions[$value] = $label;
                }
            }

            $element->setValueOptions($valueOptions);
        }

        $markup .= '<div class="col-md-' . $this->getSizeForElement() . $classCheckbox . '">' . $formControls($element) . '</div>';

        return $this->openTag($element) . $markup . $this->closeTag();
    }

    public function openTag(ElementInterface $element): string
    {
        $id = $this->getId($element);
        $id = trim(strtr($id, ['[' => '-', ']' => '']), '-');

        $classHide = $element->getOption('hidden') ? ' hidden' : null;
        $classError = null;

        if ($element instanceof Hidden) {
            $classHide = ' hidden';
        }

        if ($element->getMessages() !== []) {
            $classError = ' has-error';
        }

        return sprintf(
            $this->templateOpenTag,
            $classHide,
            $classError,
            $id,
        );
    }

    public function closeTag(): string
    {
        return $this->templateCloseTag;
    }

    protected function getFormControlLabel(): FormControlLabel
    {
        if ($this->formControlLabel instanceof FormControlLabel) {
            return $this->formControlLabel;
        }

        $this->formControlLabel = new FormControlLabel();
        $this->formControlLabel->setTranslator($this->getTranslator());
        $this->formControlLabel->setView($this->getView());

        return $this->formControlLabel;
    }

    protected function getFormControls(): FormControls
    {
        if ($this->formControls instanceof FormControls) {
            return $this->formControls;
        }

        $this->formControls = new FormControls();
        $this->formControls->setTranslator($this->getTranslator());
        $this->formControls->setView($this->getView());

        return $this->formControls;
    }
}
