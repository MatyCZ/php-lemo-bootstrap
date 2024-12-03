<?php

declare(strict_types=1);

namespace Lemo\Bootstrap\Form\View\Helper;

use Laminas\Form\ElementInterface;

use function sprintf;

class FormControlButton extends AbstractHelper
{
    protected string $template = '<span class="input-group-btn">%s</span>';

    public function __invoke(?ElementInterface $element = null): self|string
    {
        if (!$element instanceof ElementInterface) {
            return $this;
        }

        return $this->render($element);
    }

    public function render(ElementInterface $element): string
    {
        $string = '';

        if (null !== $element->getOption('button')) {
            $button = $element->getOption('button');

            if (null !== ($translator = $this->getTranslator())) {
                $button = $translator->translate(
                    $button,
                    $this->getTranslatorTextDomain(),
                );
            }

            $string .= sprintf($this->getTemplate(), $button);
        }

        return $string;
    }

    public function setTemplate(string $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }
}
