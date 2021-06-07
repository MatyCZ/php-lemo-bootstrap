<?php

namespace Lemo\Bootstrap\Form\View\Helper;

use Laminas\Form\View\Helper\AbstractHelper as ZendAbstractHelper;

abstract class AbstractHelper extends ZendAbstractHelper
{
    protected static bool $renderErrorMessages = true;
    protected static int $sizeForElement = 6;
    protected static int $sizeForLabel = 6;
    protected static int $sizeOfBox = 12;

    /**
     * @param  bool $renderErrorMessages
     * @return self
     */
    public function setRenderErrorMessages(bool $renderErrorMessages): self
    {
        self::$renderErrorMessages = $renderErrorMessages;

        return $this;
    }

    /**
     * @return bool
     */
    protected function getRenderErrorMessages(): bool
    {
        return self::$renderErrorMessages;
    }

    /**
     * @param  int $sizeBox
     * @return self
     */
    public function setSizeOfBox(int $sizeBox): self
    {
        self::$sizeOfBox = $sizeBox;

        $this->calculateSizes();

        return $this;
    }

    /**
     * @return int
     */
    protected function getSizeOfBox(): int
    {
        return self::$sizeOfBox;
    }

    /**
     * @param  int $sizeForElement
     * @return self
     */
    public function setSizeForElement(int $sizeForElement): self
    {
        self::$sizeForElement = $sizeForElement;

        return $this;
    }

    /**
     * @return int
     */
    public function getSizeForElement(): int
    {
        return self::$sizeForElement;
    }

    /**
     * @param  int $sizeForLabel
     * @return self
     */
    public function setSizeForLabel(int $sizeForLabel): self
    {
        self::$sizeForLabel = $sizeForLabel;

        return $this;
    }

    /**
     * @return int
     */
    public function getSizeForLabel(): int
    {
        return self::$sizeForLabel;
    }

    /**
     * @return self
     */
    private function calculateSizes(): self
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