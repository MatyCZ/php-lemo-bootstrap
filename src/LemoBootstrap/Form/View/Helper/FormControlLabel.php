<?php

namespace LemoBootstrap\Form\View\Helper;

use LemoBootstrap\Exception;
use Zend\Form\ElementInterface;
use Zend\Form\Form as ZendForm;
use Zend\Form\View\Helper\AbstractHelper;
use Zend\InputFilter\InputFilterInterface;

class FormControlLabel extends AbstractHelper
{
    const APPEND  = 'append';
    const PREPEND = 'prepend';

    /**
     * Attributes valid for the label tag
     *
     * @var array
     */
    protected $validTagAttributes = array(
        'for'  => true,
        'form' => true,
    );

    /**
     * Generate a form label, optionally with content
     *
     * Always generates a "for" statement, as we cannot assume the form input
     * will be provided in the $labelContent.
     *
     * @param  ElementInterface $element
     * @param  int              $size
     * @param  null|string      $labelContent
     * @param  string           $position
     * @throws Exception\DomainException
     * @return string|FormControlLabel
     */
    public function __invoke(ElementInterface $element = null, $size = 4, $labelContent = null, $position = null)
    {
        if (!$element) {
            return $this;
        }

        $label   = '';
        if ($labelContent === null || $position !== null) {
            $label = $element->getLabel();
            if (empty($label)) {
                throw new Exception\DomainException(sprintf(
                    '%s expects either label content as the second argument, ' .
                    'or that the element provided has a label attribute; neither found',
                    __METHOD__
                ));
            }

            if (null !== ($translator = $this->getTranslator())) {
                $label = $translator->translate(
                    $label, $this->getTranslatorTextDomain()
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

        // Najdeme si formular
        $inputFilter = null;
        foreach ($this->getView()->vars() as $var) {

            if ($var instanceof ZendForm) {
                $inputFilter = $var->getInputFilter();
            }
        }

        // ELement je povinny, pridame hvezdicku
        if ($inputFilter->has($element->getName())) {
            if (!$inputFilter->get($element->getName()) instanceof InputFilterInterface && true === $inputFilter->get($element->getName())->isRequired()) {
                $labelContent .= '&nbsp;<em class="required">*</em>';
            }
        }

        return $this->openTag($element, $size) . $labelContent . $this->closeTag();
    }

    /**
     * Generate an opening label tag
     *
     * @param  null|array|ElementInterface $attributesOrElement
     * @param  null|int                    $size
     * @throws Exception\InvalidArgumentException
     * @throws Exception\DomainException
     * @return string
     */
    public function openTag($attributesOrElement = null, $size = 4)
    {
        if (!is_array($attributesOrElement) && !$attributesOrElement instanceof ElementInterface) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s expects an array or Zend\Form\ElementInterface instance; received "%s"',
                __METHOD__,
                (is_object($attributesOrElement) ? get_class($attributesOrElement) : gettype($attributesOrElement))
            ));
        }

        $id = $this->getId($attributesOrElement);
        if (null === $id) {
            throw new Exception\DomainException(sprintf(
                '%s expects the Element provided to have either a name or an id present; neither found',
                __METHOD__
            ));
        }

        $labelAttributes = $attributesOrElement->getLabelAttributes();
        $attributes = array('for' => $id);

        if (!empty($labelAttributes)) {
            $attributes = array_merge($labelAttributes, $attributes);
        }

        if (array_key_exists('class', $attributes)) {
            if(array_key_exists('class', $attributes)) {
                if(false === strpos($attributes['class'], 'control-label')) {
                    $attributes['class'] = trim($attributes['class'] . ' ' . 'control-label');
                }
            } else {
                $attributes['class'] = 'control-label col-lg-' . $size;
            }
        } else {
            $attributes['class'] = 'control-label col-lg-' . $size;
        }

        $attributes = $this->createAttributesString($attributes);
        return sprintf('<label %s>', $attributes);
    }

    /**
     * Return a closing label tag
     *
     * @return string
     */
    public function closeTag()
    {
        return '</label>';
    }
}
