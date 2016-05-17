<?php

namespace LemoBootstrap\Form\View\Helper;

use Zend\Form\View\Helper\AbstractHelper as ZendAbstractHelper;

abstract class AbstractHelper extends ZendAbstractHelper
{
    /**
     * @var int
     */
    protected static $sizeForElement = 10;
    /**
     * @var int
     */
    protected static $sizeForLabel = 2;

    /**
     * @var int
     */
    protected static $sizeOfBox = 12;

    /**
     * @param  int $sizeBox
     * @return int
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

        if ($sizeBox > 10) {
            $sizeLabel = 2;
            $sizeElement = 10;
        } elseif ($sizeBox > 8) {
            $sizeLabel = 4;
            $sizeElement = 8;
        } else {
            $sizeLabel = 6;
            $sizeElement = 6;
        }

        $this->setSizeForElement($sizeElement);
        $this->setSizeForLabel($sizeLabel);

        return $this;
    }
}