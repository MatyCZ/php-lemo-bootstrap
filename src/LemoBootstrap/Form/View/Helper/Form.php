<?php

namespace LemoBootstrap\Form\View\Helper;

use LemoBootstrap\Exception;
use Zend\Form\Element\Collection;
use Zend\Form\FormInterface;
use Zend\Form\View\Helper\Form as FormHelper;

class Form extends FormHelper
{
    const STYLE_HORIZONTAL = 'horizontal';
    const STYLE_INLINE     = 'inline';
    const STYLE_SEARCH     = 'search';

    /**
     * Form style
     *
     * @var string
     */
    protected $formStyle = self::STYLE_HORIZONTAL;

    /**
     * Display a Form
     *
     * @param  FormInterface $form
     * @param  null|string   $formStyle
     * @return string
     */
    public function __invoke(FormInterface $form = null, $formStyle = null)
    {
        if(null !== $formStyle) {
            $this->setFormStyle($formStyle);
        }

        if (null === $form) {
            return $this;
        }

        $form->prepare();

        return parent::render($form);
    }

    /**
     * Generate an opening form tag
     *
     * @param  null|FormInterface $form
     * @param  null|string        $formStyle
     * @return string
     */
    public function openTag(FormInterface $form = null, $formStyle = null)
    {
        if(null !== $formStyle) {
            $this->setFormStyle($formStyle);
        }

        $attributes = array(
            'action' => '',
            'method' => 'get',
        );

        if ($form instanceof FormInterface) {
            $formAttributes = $form->getAttributes();
            if (!array_key_exists('id', $formAttributes) && array_key_exists('name', $formAttributes)) {
                $formAttributes['id'] = $formAttributes['name'];
            }
            $attributes = array_merge($attributes, $formAttributes);
        }

        // Append form style to class
        if (array_key_exists('class', $attributes)) {
            if(false === strpos($attributes['class'], 'form-' . $this->getFormStyle())) {
                $attributes['class'] = trim($attributes['class'] . ' ' . 'form-' . $this->getFormStyle());
            }
        } else {
            $attributes['class'] = 'form-' . $this->getFormStyle();
        }

        $tag = sprintf('<form %s>', $this->createAttributesString($attributes));

        return $tag;
    }

    /**
     * Set form layout style
     *
     * @param  string $formStyle
     * @return Form
     */
    public function setFormStyle($formStyle)
    {
        $this->formStyle = $formStyle;

        return $this;
    }

    /**
     * Get form layout style
     *
     * @return string
     */
    public function getFormStyle()
    {
        return $this->formStyle;
    }
}
