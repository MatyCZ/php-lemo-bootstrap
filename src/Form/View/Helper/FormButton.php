<?php

declare(strict_types=1);

namespace Lemo\Bootstrap\Form\View\Helper;

use Laminas\Form\ElementInterface;
use Laminas\Form\Exception;
use Laminas\Form\View\Helper\FormInput;

use function is_array;
use function sprintf;
use function strtolower;

class FormButton extends FormInput
{
    /**
     * Attributes valid for the button tag
     *
     * @var array
     */
    protected $validTagAttributes = [
        'name'           => true,
        'autofocus'      => true,
        'disabled'       => true,
        'form'           => true,
        'formaction'     => true,
        'formenctype'    => true,
        'formmethod'     => true,
        'formnovalidate' => true,
        'formtarget'     => true,
        'type'           => true,
        'value'          => true,
    ];

    /**
     * Valid values for the button type
     *
     * @var array
     */
    protected $validTypes = [
        'button' => true,
        'reset'  => true,
        'submit' => true,
    ];

    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     */
    #[\Override]
    public function __invoke(?ElementInterface $element = null, ?string $buttonContent = null): self|string
    {
        if (!$element instanceof ElementInterface) {
            return $this;
        }

        return $this->render($element, $buttonContent);
    }

    /**
     * Render a form <button> element from the provided $element,
     * using content from $buttonContent or the element's "label" attribute
     *
     * @throws Exception\DomainException
     */
    #[\Override]
    public function render(ElementInterface $element, ?string $buttonContent = null): string
    {
        $openTag = $this->openTag($element);

        if (null === $buttonContent) {
            $buttonContent = $element->getLabel();
            if (null === $buttonContent) {
                throw new Exception\DomainException(
                    sprintf(
                        '%s expects either button content as the second argument, ' .
                        'or that the element provided has a label value; neither found',
                        __METHOD__,
                    ),
                );
            }

            if (null !== ($translator = $this->getTranslator())) {
                $buttonContent = $translator->translate(
                    $buttonContent,
                    $this->getTranslatorTextDomain(),
                );
            }
        }

        $escapeHtmlHelper = $this->getEscapeHtmlHelper();

        return $openTag . $escapeHtmlHelper($buttonContent) . $this->closeTag();
    }

    /**
     * @throws Exception\InvalidArgumentException
     * @throws Exception\DomainException
     */
    public function openTag(ElementInterface|array|null $attributesOrElement = null): string
    {
        if (null === $attributesOrElement) {
            return '<button>';
        }

        if (is_array($attributesOrElement)) {
            return sprintf(
                '<button %s>',
                $this->createAttributesString($attributesOrElement),
            );
        }

        $element = $attributesOrElement;
        $name = $element->getName();
        if (($name === null || $name === '' || $name === '0') && $name !== 0) {
            throw new Exception\DomainException(
                sprintf(
                    '%s requires that the element has an assigned name; none discovered',
                    __METHOD__,
                ),
            );
        }

        $attributes = $element->getAttributes();
        $attributes['name'] = $name;
        $attributes['type'] = $this->getType($element);
        $attributes['value'] = $element->getValue();

        return sprintf(
            '<button %s>',
            $this->createAttributesString($attributes),
        );
    }

    public function closeTag(): string
    {
        return '</button>';
    }

    #[\Override]
    protected function getType(ElementInterface $element): string
    {
        $type = $element->getAttribute('type');

        if (empty($type)) {
            return 'button';
        }

        $type = strtolower($type);

        if (!isset($this->validTypes[$type])) {
            return 'button';
        }

        return $type;
    }
}
