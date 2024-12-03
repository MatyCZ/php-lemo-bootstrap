<?php

declare(strict_types=1);

namespace Lemo\Bootstrap\Form\View\Helper;

use Laminas\Form\ElementInterface;

use function is_iterable;
use function sprintf;
use function strtr;
use function trim;

use const PHP_EOL;

class FormControls extends AbstractHelper
{
    protected ?FormControl $formControl = null;

    protected string $templateCloseTag = '';

    protected string $templateOpenTag = '';

    public function __invoke(?ElementInterface $element = null): self|string
    {
        if (!$element instanceof ElementInterface) {
            return $this;
        }

        return $this->render($element);
    }

    public function render(ElementInterface $element): string
    {
        $formControl = $this->getFormControl();

        $content = '';

        if (is_iterable($element)) {
            foreach ($element as $el) {
                $content .= $formControl($el) . PHP_EOL;
            }
        } else {
            $content .= $formControl($element) . PHP_EOL;
        }

        return $this->openTag($element) . $content . $this->closeTag();
    }

    public function openTag(ElementInterface $element): string
    {
        $id = $this->getId($element);
        $id = trim(strtr($id, ['[' => '-', ']' => '']), '-');

        return sprintf(
            $this->templateOpenTag,
            $id,
        );
    }

    public function closeTag(): string
    {
        return $this->templateCloseTag;
    }

    protected function getFormControl(): FormControl
    {
        if ($this->formControl instanceof FormControl) {
            return $this->formControl;
        }

        $this->formControl = new FormControl();
        $this->formControl->setTranslator($this->getTranslator());
        $this->formControl->setView($this->getView());

        return $this->formControl;
    }
}
