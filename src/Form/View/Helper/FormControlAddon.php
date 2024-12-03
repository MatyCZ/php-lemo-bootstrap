<?php

declare(strict_types=1);

namespace Lemo\Bootstrap\Form\View\Helper;

use Laminas\Form\ElementInterface;

use function sprintf;

class FormControlAddon extends AbstractHelper
{
    protected string $template = '<span class="input-group-addon">%s</span>';

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

        if (null !== $element->getOption('addon')) {
            $addon = $element->getOption('addon');

            if (null !== ($translator = $this->getTranslator())) {
                $addon = $translator->translate(
                    $addon,
                    $this->getTranslatorTextDomain(),
                );
            }

            $string .= sprintf($this->getTemplate(), $addon);
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
