<?php

namespace LemoBootstrap\Form\View\Helper;

use Zend\Form\View\Helper\AbstractHelper as ZendAbstractHelper;

abstract class AbstractHelper extends ZendAbstractHelper
{
    /**
     * @var bool
     */
    protected static $renderErrorMessages = true;

    /**
     * @var int
     */
    protected static $sizeForElement = 6;
    /**
     * @var int
     */
    protected static $sizeForLabel = 6;

    /**
     * @var int
     */
    protected static $sizeOfBox = 12;

    /**
     * @param  bool $renderErrorMessages
     * @return $this
     */
    public function setRenderErrorMessages($renderErrorMessages)
    {
        self::$renderErrorMessages = (bool) $renderErrorMessages;

        return $this;
    }

    /**
     * @return bool
     */
    protected function getRenderErrorMessages()
    {
        return self::$renderErrorMessages;
    }

    /**
     * @param  int $sizeBox
     * @return $this
     */
    public function setSizeOfBox($sizeBox)
    {
        self::$sizeOfBox = $sizeBox;

        $this->calculateSizes();

        return $this;
    }

    /**
     * @return int
     */
    protected function getSizeOfBox()
    {
        return self::$sizeOfBox;
    }

    /**
     * @param  int $sizeForElement
     * @return $this
     */
    public function setSizeForElement($sizeForElement)
    {
        self::$sizeForElement = $sizeForElement;

        return $this;
    }

    /**
     * @return int
     */
    public function getSizeForElement()
    {
        return self::$sizeForElement;
    }

    /**
     * @param  int $sizeForLabel
     * @return $this
     */
    public function setSizeForLabel($sizeForLabel)
    {
        self::$sizeForLabel = $sizeForLabel;

        return $this;
    }

    /**
     * @return int
     */
    public function getSizeForLabel()
    {
        return self::$sizeForLabel;
    }

    /**
     * @return $this
     */
    private function calculateSizes()
    {
        $sizeBox = $this->getSizeOfBox();

//        if ($sizeBox > 10) {
//            $sizeLabel = 2;
//            $sizeElement = 10;
//        } elseif ($sizeBox > 8) {
//            $sizeLabel = 4;
//            $sizeElement = 8;
//        } else {
            $sizeLabel = 6;
            $sizeElement = 6;
//        }

        $this->setSizeForElement($sizeElement);
        $this->setSizeForLabel($sizeLabel);

        return $this;
    }
}