<?php

namespace LemoBootstrap\Html\View\Helper;

use LemoBootstrap\Exception;
use LemoBootstrap\Html\ElementInterface;

class HtmlButton extends AbstractHelper
{
    /**
     * @var HtmlGlyphicon
     */
    protected $helperHtmlGlyphicon;

    /**
     * Attributes valid for the button tag
     *
     * @var array
     */
    protected $validTagAttributes = array(
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
    );

    /**
     * Valid values for the button type
     *
     * @var array
     */
    protected $validTypes = array(
        'button'         => true,
        'reset'          => true,
        'submit'         => true,
    );

    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @param  ElementInterface|null $element
     * @param  null|string           $buttonContent
     * @return string|HtmlButton
     */
    public function __invoke(ElementInterface $element = null, $buttonContent = null)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element, $buttonContent);
    }

    /**
     * Render a form <button> element from the provided $element,
     * using content from $buttonContent or the element's "content" attribute
     *
     * @param  ElementInterface $element
     * @param  null|string $buttonContent
     * @throws Exception\DomainException
     * @return string
     */
    public function render(ElementInterface $element, $buttonContent = null)
    {
        $helperEscape = $this->getEscapeHtmlHelper();
        $helperHtmlGlyphicon = $this->getHelperHtmlGlyphicon();

        $openTag = $this->openTag($element);

        if (null === $buttonContent) {
            $buttonContent = $element->getContent();
            if (null === $buttonContent) {
                throw new Exception\DomainException(sprintf(
                    '%s expects either button content as the second argument, ' .
                    'or that the element provided has a value; neither found',
                    __METHOD__
                ));
            }

            if (null !== ($translator = $this->getTranslator())) {
                $buttonContent = $translator->translate(
                    $buttonContent, $this->getTranslatorTextDomain()
                );
            }
        }

        $content = '';
        if (null !== $element->getGlyphicon()) {
            $content .= $helperHtmlGlyphicon($element->getGlyphicon()) . ' ';
        }
        $content .= $helperEscape($buttonContent);

        return $openTag . $content . $this->closeTag();
    }

    /**
     * Generate an opening button tag
     *
     * @param  null|array|ElementInterface $attributesOrElement
     * @throws Exception\InvalidArgumentException
     * @throws Exception\DomainException
     * @return string
     */
    public function openTag($attributesOrElement = null)
    {
        if (null === $attributesOrElement) {
            return '<button>';
        }

        if (is_array($attributesOrElement)) {
            $attributes = $this->createAttributesString($attributesOrElement);
            return sprintf('<button %s>', $attributes);
        }

        if (!$attributesOrElement instanceof ElementInterface) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s expects an array or LemoBootstrap\Html\ElementInterface instance; received "%s"',
                __METHOD__,
                (is_object($attributesOrElement) ? get_class($attributesOrElement) : gettype($attributesOrElement))
            ));
        }

        $element = $attributesOrElement;

        $attributes          = $element->getAttributes();
        $attributes['type']  = $this->getType($element);

        return sprintf(
            '<button %s>',
            $this->createAttributesString($attributes)
        );
    }

    /**
     * Return a closing button tag
     *
     * @return string
     */
    public function closeTag()
    {
        return '</button>';
    }

    /**
     * Determine button type to use
     *
     * @param  ElementInterface $element
     * @return string
     */
    protected function getType(ElementInterface $element)
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

    /**
     * Retrieve the HtmlGlyphicon helper
     *
     * @return HtmlGlyphicon
     */
    protected function getHelperHtmlGlyphicon()
    {
        if ($this->helperHtmlGlyphicon) {
            return $this->helperHtmlGlyphicon;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->helperHtmlGlyphicon = $this->view->plugin('htmlbutton');
        }

        if (!$this->helperHtmlGlyphicon instanceof HtmlGlyphicon) {
            $this->helperHtmlGlyphicon = new HtmlGlyphicon();
        }

        return $this->helperHtmlGlyphicon;
    }
}
