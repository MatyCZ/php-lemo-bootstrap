<?php

declare(strict_types=1);

namespace Lemo\Bootstrap\Form\View\Helper;

use DateTime;
use IntlDateFormatter;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Textarea;
use Laminas\Form\ElementInterface;
use Laminas\Form\View\Helper\FormElement;
use Locale;

use function current;
use function html_entity_decode;
use function implode;
use function in_array;
use function is_array;
use function str_replace;
use function strtolower;
use function strtr;
use function trim;

use const ENT_COMPAT;
use const PHP_EOL;

class FormControl extends AbstractHelper
{
    /**
     * List of elements with value options
     */
    protected array $elementsValueOptions = [
        'multi_checkbox',
        'multicheckbox',
        'radio',
    ];

    public function __construct(
        protected ?FormControlAddon $formControlAddon = null,
        protected ?FormControlButton $formControlButton = null,
        protected ?FormControlHelpBlock $formControlHelpBlock = null,
        protected ?FormElement $formElement = null,
    ) {}

    public function __invoke(?ElementInterface $element = null): self|string
    {
        if (!$element instanceof ElementInterface) {
            return $this;
        }

        return $this->render($element);
    }

    public function render(ElementInterface $element): string
    {
        $formControlAddon = $this->formControlAddon;
        $formControlButton = $this->formControlButton;
        $formControlHelpBlock  = $this->formControlHelpBlock;
        $formElement = $this->formElement;

        $id = $this->getId($element);
        $id = trim(strtr($id, ['[' => '-', ']' => '']), '-');

        $type = strtolower($element->getAttribute('type'));
        $classCheckboxOrRadio = null;
        $content = '';

        // Renderovani datumu dle locale
        if ($element->getValue() instanceof DateTime) {
            $intlDateFormatter = new IntlDateFormatter(
                Locale::getDefault(),
                IntlDateFormatter::MEDIUM,
                IntlDateFormatter::NONE,
                $element->getValue()->getTimezone()->getName(),
                IntlDateFormatter::GREGORIAN,
            );

            $element->setValue(
                str_replace(
                    ' ',
                    '',
                    $intlDateFormatter->format($element->getValue()),
                ),
            );
        }

        // Element value
        if (
            ($element instanceof Text || $element instanceof Textarea)
            && $element->getValue()
        ) {
            $element->setValue(
                html_entity_decode(
                    (string) $element->getValue(),
                    ENT_COMPAT,
                    'UTF-8',
                ),
            );
        }

        // Add class to value options for multicheckbox and radio elements
        if (in_array($type, $this->elementsValueOptions)) {
            $classCheckboxOrRadio = ($type === 'radio') ? 'radio' : 'checkbox';

            $content = '<div class="' . $classCheckboxOrRadio . '">';
        }

        $element->setAttribute('id', $id);

        if (
            null !== $element->getOption('addon')
            || null !== $element->getOption('button')
            || null !== $element->getOption('append')
            || null !== $element->getOption('prepend')
        ) {
            $content .= '<div class="input-group input-group-sm">' . PHP_EOL;
        }

        // Addon - Pre
        if (null !== $element->getOption('prepend')) {
            $content .= $formControlAddon(
                $element->setOption('addon', $element->getOption('prepend')),
            ) . PHP_EOL;
        }

        // Element
        $content .= $formElement($element) . PHP_EOL;

        // Addon - Post
        if (null !== $element->getOption('append')) {
            $content .= $formControlAddon(
                $element->setOption('addon', $element->getOption('append')),
            ) . PHP_EOL;
        }

        // Button
        if (null !== $element->getOption('button')) {
            $content .= $formControlButton($element) . PHP_EOL;
        }

        if (in_array($type, $this->elementsValueOptions)) {
            $content = str_replace(
                '/label><label',
                '/label></div><div class="' . $classCheckboxOrRadio . '"><label',
                $content,
            );
            $content .= '</div>' . PHP_EOL;
        }

        if (
            null !== $element->getOption('button')
            || null !== $element->getOption('append')
            || null !== $element->getOption('prepend')
        ) {
            $content .= '</div>' . PHP_EOL;
        }

        if (self::$renderErrorMessages && $element->getMessages() !== []) {
            $helpBlock = $element->getOption('help-block');

            $messages = [];
            if (!empty($helpBlock)) {
                $messages[] = '<span class="text-muted">' . $helpBlock . '</span>';
            }

            foreach ($element->getMessages() as $message) {
                $messages[] = is_array($message) ? current($message) : $message;
            }

            $element->setOption('help-block', implode('<br />', $messages));
        }

        return $content . ($formControlHelpBlock($element) . PHP_EOL);
    }
}
