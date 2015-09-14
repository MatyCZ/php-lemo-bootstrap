<?php

namespace LemoBootstrap\Html\View\Helper;

use LemoBootstrap\Exception;
use LemoBootstrap\Html\ElementInterface;
use LemoBootstrap\Html\Element\FontAwesome;

class HtmlFontAwesome extends AbstractHelper
{
    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @param  ElementInterface|null $element
     * @return string|HtmlFontAwesome
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
     * Generate an opening tag
     *
     * @param  null|array|ElementInterface $attributesOrElement
     * @throws Exception\InvalidArgumentException
     * @throws Exception\DomainException
     * @return string
     */
    public function openTag($attributesOrElement = null)
    {
        if (null === $attributesOrElement) {
            return '<i>';
        }

        if (is_array($attributesOrElement)) {
            $attributes = $this->createAttributesString($attributesOrElement);
            return sprintf('<i %s>', $attributes);
        }

        if (!$attributesOrElement instanceof FontAwesome) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s expects an array or LemoBootstrap\Html\Element\FontAwesome instance; received "%s"',
                __METHOD__,
                (is_object($attributesOrElement) ? get_class($attributesOrElement) : gettype($attributesOrElement))
            ));
        }

        $element = $attributesOrElement;
        $element->addAttributeValue('class', 'fa');
        $element->addAttributeValue('class', 'fa-' . $element->getIcon());

        if (true === $element->getFixedWidth()) {
            $element->addAttributeValue('class', 'fa-fw');
        }

        if (null !== $element->getSize()) {
            $element->addAttributeValue('class', 'fa-' . $element->getSize() . 'x');
        }

        return sprintf(
            '<i %s>',
            $this->createAttributesString($element->getAttributes())
        );
    }

    /**
     * Return a closing tag
     *
     * @return string
     */
    public function closeTag()
    {
        return '</i>';
    }
}
