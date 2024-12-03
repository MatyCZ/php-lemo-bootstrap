<?php

declare(strict_types=1);

namespace Lemo\Bootstrap\Form\View\Helper;

use Laminas\Form\ElementInterface;
use Lemo\Bootstrap\Exception;

use function array_key_exists;
use function array_merge;
use function get_debug_type;
use function is_array;
use function str_contains;
use function trim;
use function sprintf;

class FormControlLabel extends AbstractHelper
{
    public const string APPEND  = 'append';

    public const string PREPEND = 'prepend';

    /**
     * Attributes valid for the label tag
     *
     * @var array
     */
    protected $validTagAttributes = [
        'for'  => true,
        'form' => true,
    ];

    /**
     * Generate a form label, optionally with content
     *
     * Always generates a "for" statement, as we cannot assume the form input
     * will be provided in the $labelContent.
     *
     * @throws Exception\DomainException
     */
    public function __invoke(
        ?ElementInterface $element = null,
        ?string $labelContent = null,
        ?string $position = null,
    ): self|string {
        if (!$element instanceof ElementInterface) {
            return $this;
        }

        $label   = '';
        if ($labelContent === null || $position !== null) {
            $label = $element->getLabel();
            if ($label === null || $label === '' || $label === '0') {
                throw new Exception\DomainException(
                    sprintf(
                        '%s expects either label content as the second argument, ' .
                        'or that the element provided has a label attribute; neither found',
                        __METHOD__,
                    ),
                );
            }

            if (null !== ($translator = $this->getTranslator())) {
                $label = $translator->translate(
                    $label,
                    $this->getTranslatorTextDomain(),
                );
            }
        }

        if ($label && $labelContent) {
            switch ($position) {
                case self::APPEND:
                    $labelContent .= $label;
                    break;
                case self::PREPEND:
                default:
                    $labelContent = $label . $labelContent;
                    break;
            }
        }

        if ($label && null === $labelContent) {
            $labelContent = $label;
        }

        // Element je povinny, pridame hvezdicku
        if ($element->hasAttribute('required')) {
            $labelContent .= ' <em class="required">*</em>';
        }

        return $this->openTag($element) . $labelContent . $this->closeTag();
    }

    /**
     * @throws Exception\InvalidArgumentException
     * @throws Exception\DomainException
     */
    public function openTag(ElementInterface|array|null $attributesOrElement = null): string
    {
        if (!is_array($attributesOrElement) && !$attributesOrElement instanceof ElementInterface) {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    '%s expects an array or Laminas\Form\ElementInterface instance; received "%s"',
                    __METHOD__,
                    get_debug_type($attributesOrElement),
                ),
            );
        }

        $id = $this->getId($attributesOrElement);
        $id = trim(strtr($id, ['[' => '-', ']' => '']), '-');
        if ('' === $id) {
            throw new Exception\DomainException(
                sprintf(
                    '%s expects the Element provided to have either a name or an id present; neither found',
                    __METHOD__,
                ),
            );
        }

        $labelAttributes = $attributesOrElement->getLabelAttributes();
        $attributes = ['for' => $id];

        if (!empty($labelAttributes)) {
            $attributes = array_merge($labelAttributes, $attributes);
        }

        if (array_key_exists('class', $attributes)) {
            if (!str_contains((string) $attributes['class'], 'control-label')) {
                $attributes['class'] = trim($attributes['class'] . ' ' . 'control-label');
            }
        } else {
            $attributes['class'] = 'control-label col-md-' . $this->getSizeForLabel();
        }

        $attributes = $this->createAttributesString($attributes);

        return sprintf('<label %s>', $attributes);
    }

    public function closeTag(): string
    {
        return '</label>';
    }
}
