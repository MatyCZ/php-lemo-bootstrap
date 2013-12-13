<?php

namespace LemoBootstrap\Html\View\Helper;

use LemoBootstrap\Exception;
use LemoBootstrap\Html\ElementInterface;

class HtmlGlyphicon extends AbstractHelper
{
    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @param  ElementInterface|null $element
     * @return string|HtmlButton
     */
    public function __invoke(ElementInterface $element = null)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element);
    }

    /**
     * Render a form <span> element from the provided $element
     *
     * @param  ElementInterface $element
     * @throws Exception\DomainException
     * @return string
     */
    public function render(ElementInterface $element)
    {
        return $this->openTag($element) . $this->closeTag();
    }

    /**
     * Generate an opening span tag
     *
     * @param  null|array|ElementInterface $attributesOrElement
     * @throws Exception\InvalidArgumentException
     * @throws Exception\DomainException
     * @return string
     */
    public function openTag($attributesOrElement = null)
    {
        if (null === $attributesOrElement) {
            return '<span>';
        }

        if (is_array($attributesOrElement)) {
            $attributes = $this->createAttributesString($attributesOrElement);
            return sprintf('<span %s>', $attributes);
        }

        if (!$attributesOrElement instanceof ElementInterface) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s expects an array or LemoBootstrap\Html\ElementInterface instance; received "%s"',
                __METHOD__,
                (is_object($attributesOrElement) ? get_class($attributesOrElement) : gettype($attributesOrElement))
            ));
        }

        $element = $attributesOrElement;
        $element->addAttributeValue('class', 'glyphicon-' . $element->getIcon());

        return sprintf(
            '<span %s>',
            $this->createAttributesString($element->getAttributes())
        );
    }

    /**
     * Return a closing glyphicon tag
     *
     * @return string
     */
    public function closeTag()
    {
        return '</span>';
    }
}
