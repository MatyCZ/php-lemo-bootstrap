<?php

namespace LemoBootstrap\Form\View\Helper\Captcha;

use Laminas\Captcha\Image as CaptchaAdapter;
use Laminas\Form\Element\Captcha as ElementCaptcha;
use Laminas\Form\Element\Hidden;
use Laminas\Form\ElementInterface;
use Laminas\Form\Exception;
use Laminas\Form\View\Helper\Captcha\AbstractWord;
use LemoBootstrap\Form\View\Helper\FormControlHelpBlock;
use LemoBootstrap\Form\View\Helper\FormControlLabel;
use LemoBootstrap\Form\View\Helper\FormGroupElement;

class Image extends AbstractWord
{
    /**
     * @var FormControlLabel
     */
    protected $helperControlLabel;

    /**
     * @var FormGroupElement
     */
    protected $helperGroupElement;

    /**
     * @var FormControlHelpBlock
     */
    protected $helperHelpBlock;

    /**
     * @var string
     */
    protected $templateCloseTag = '</div>';

    /**
     * @var string
     */
    protected $templateOpenTag = '<div class="form-group form-group-sm%s%s" id="form-group-captcha">';

    /**
     * Render the captcha
     *
     * @param  ElementInterface|ElementCaptcha $element
     * @throws Exception\DomainException
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $captcha = $element->getCaptcha();
        $helperLabel = $this->getHelperControlLabel();
        $helperBlock = $this->getHelperHelpBlock();

        $markup = $this->openTag($element);
        if ('' != $element->getLabel()) {
            $markup .= $helperLabel($element);
        }

        $markup .= '<div class="col-md-6">';

        if ($captcha === null || !$captcha instanceof CaptchaAdapter) {
            throw new Exception\DomainException(sprintf('%s requires that the element has a "captcha" attribute of type Laminas\Captcha\Image; none found', __METHOD__));
        }

        $captcha->generate();

        $imgAttributes  = [
            'width'  => $captcha->getWidth(),
            'height' => $captcha->getHeight(),
            'alt'    => $captcha->getImgAlt(),
            'src'    => $captcha->getImgUrl() . $captcha->getId() . $captcha->getSuffix(),
        ];
        $closingBracket = $this->getInlineClosingBracket();
        $img            = sprintf('<img %s%s', $this->createAttributesString($imgAttributes), $closingBracket);

        $position     = $this->getCaptchaPosition();
        $separator    = $this->getSeparator();

        $captchaInput = $this->renderCaptchaInputs($element);

        $pattern = '%s %s %s';
        if ($position == self::CAPTCHA_PREPEND) {
            $markup .= sprintf($pattern, $captchaInput, $separator, $img);
        } else {
            $markup .= sprintf($pattern, $img, $separator, $captchaInput);
        }

        if (count($element->getMessages()) > 0) {
            $helpBlock = $element->getOption('help-block');

            $messages = [];
            if (!empty($helpBlock)) {
                $messages[] = '<span class="text-muted">' . $helpBlock . '</span>';
            }

            foreach ($element->getMessages() as $message) {
                if (is_array($message)) {
                    $messages[] = current($message);
                } else {
                    $messages[] = $message;
                }
            }
            $element->setOption('help-block', implode('<br />', $messages));
        }

        $markup .= $helperBlock->render($element);
        $markup .= '</div>';
        $markup .= $this->closeTag();

        return $markup;
    }

    /**
     * Generate an opening form tag
     *
     * @param  ElementInterface $element
     * @return string
     */
    public function openTag(ElementInterface $element)
    {
        $id = $this->getId($element);
        $id = trim(strtr($id, array('[' => '-', ']' => '')), '-');

        $classHide = $element->getOption('hidden') ? ' hidden' : null;
        $classError = null;

        if ($element instanceof Hidden) {
            $classHide = ' hidden';
        }
        if (count($element->getMessages()) > 0) {
            $classError = ' has-error';
        }

        return sprintf(
            $this->templateOpenTag,
            $classHide,
            $classError,
            $id
        );
    }

    /**
     * Generate a closing form tag
     *
     * @return string
     */
    public function closeTag()
    {
        return $this->templateCloseTag;
    }

    /**
     * Retrieve the FormControlLabel helper
     *
     * @return FormControlLabel
     */
    protected function getHelperControlLabel()
    {
        if ($this->helperControlLabel) {
            return $this->helperControlLabel;
        }

        if (!$this->helperControlLabel instanceof FormControlLabel) {
            $this->helperControlLabel = new FormControlLabel();
        }

        $this->helperControlLabel->setTranslator($this->getTranslator());
        $this->helperControlLabel->setView($this->getView());

        return $this->helperControlLabel;
    }

    /**
     * Retrieve the FormGroupElement helper
     *
     * @return FormGroupElement
     */
    protected function getHelperGroupElement()
    {
        if ($this->helperControlLabel) {
            return $this->helperGroupElement;
        }

        if (!$this->helperGroupElement instanceof FormGroupElement) {
            $this->helperGroupElement = new FormGroupElement();
        }

        $this->helperGroupElement->setTranslator($this->getTranslator());
        $this->helperGroupElement->setView($this->getView());

        return $this->helperGroupElement;
    }

    /**
     * Retrieve the FormControlLabel helper
     *
     * @return FormControlHelpBlock
     */
    protected function getHelperHelpBlock()
    {
        if ($this->helperHelpBlock) {
            return $this->helperHelpBlock;
        }

        if (!$this->helperHelpBlock instanceof FormControlHelpBlock) {
            $this->helperHelpBlock = new FormControlHelpBlock();
        }

        $this->helperHelpBlock->setTranslator($this->getTranslator());
        $this->helperHelpBlock->setView($this->getView());

        return $this->helperHelpBlock;
    }
}