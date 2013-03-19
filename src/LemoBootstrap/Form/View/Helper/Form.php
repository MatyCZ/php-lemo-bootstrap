<?php

namespace LemoBootstrap\View\Helper;

use LemoBootstrap\Exception;
use Zend\Form\Element\Collection;
use Zend\Form\Form as ZendForm;
use Zend\Form\FormInterface;

class Form extends ZendForm
{
    const STYLE_HORIZONTAL = 'horizontal';
    const STYLE_INLINE     = 'inline';
    const STYLE_SEARCH     = 'search';

    /**
     * List of allowed layout styles
     *
     * @var array
     */
    protected $allowedFormStyles = array(
        self::STYLE_HORIZONTAL,
        self::STYLE_INLINE,
        self::STYLE_SEARCH,
    );

    /**
     * Form style
     *
     * @var string
     */
    protected $formStyle = self::STYLE_HORIZONTAL;

    /**
     * Display a Form
     *
     * @param  ZendForm    $form
     * @param  null|string $formStyle
     * @return string
     */
    public function __invoke(ZendForm $form, $formStyle = null)
    {
        if(null !== $formStyle) {
            $this->setFormStyle($formStyle);
        }

        if (!$form) {
            return $this;
        }

        return parent::render($form);
    }

    /**
     * Render a form from the provided $form,
     *
     * @param  FormInterface $form
     * @return string
     */
    public function render(FormInterface $form)
    {
        if (null !== $this->getFormStyle()) {
            $class = 'form-' . $this->getFormStyle();

            if($form->hasAttribute('class')) {
                $formClass = $form->getAttribute('class');

                if(false === strpos($formClass, $class)) {
                    $form->setAttribute('class', trim($formClass . ' ' . $class));
                }
            } else {
                $form->setAttribute('class', $class);
            }
        }

        return parent::render($form);
    }

    /**
     * Set form layout style
     *
     * @param  string $formStyle
     * @throws Exception\InvalidArgumentException
     * @return Form
     */
    public function setFormStyle($formStyle)
    {
        $formStyle = strtolower($formStyle);

        if(in_array($formStyle, $this->allowedFormStyles)) {
            throw new Exception\InvalidArgumentException(
                "Invalid layout style given"
            );
        }

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
