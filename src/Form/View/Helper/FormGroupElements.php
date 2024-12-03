<?php

declare(strict_types=1);

namespace Lemo\Bootstrap\Form\View\Helper;

use Laminas\Form\Element\Hidden;
use Laminas\Form\ElementInterface;

use function count;
use function round;
use function strtr;
use function sprintf;
use function trim;

use const PHP_EOL;

class FormGroupElements extends AbstractHelper
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

        $markup .= '<div class="col-md-' . $this->getSizeForElement() . '">';
        $markup .= '    <div class="row">';
        foreach ($element->getElements() as $el) {
            $markup .= '    <div class="col-md-' . round(12 / count($element->getElements())) . '">';
            $markup .= '        ' . $formControls($el) . PHP_EOL;
            $markup .= '    </div>';
        }

        $markup .= '    </div>';
        $markup .= '</div>';

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
