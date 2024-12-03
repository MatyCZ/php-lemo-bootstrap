<?php

declare(strict_types=1);

namespace Lemo\Bootstrap\Form\View\Helper;

use Laminas\Form\View\Helper\AbstractHelper as ZendAbstractHelper;

abstract class AbstractHelper extends ZendAbstractHelper
{
    protected static bool $renderErrorMessages = true;

    protected static int $sizeForElement = 6;

    protected static int $sizeForLabel = 6;

    protected static int $sizeOfBox = 12;

    public function setRenderErrorMessages(bool $renderErrorMessages): self
    {
        self::$renderErrorMessages = $renderErrorMessages;

        return $this;
    }

    protected function getRenderErrorMessages(): bool
    {
        return self::$renderErrorMessages;
    }

    public function setSizeOfBox(int $sizeBox): self
    {
        self::$sizeOfBox = $sizeBox;

        $this->calculateSizes();

        return $this;
    }

    protected function getSizeOfBox(): int
    {
        return self::$sizeOfBox;
    }

    public function setSizeForElement(int $sizeForElement): self
    {
        self::$sizeForElement = $sizeForElement;

        return $this;
    }

    public function getSizeForElement(): int
    {
        return self::$sizeForElement;
    }

    public function setSizeForLabel(int $sizeForLabel): self
    {
        self::$sizeForLabel = $sizeForLabel;

        return $this;
    }

    public function getSizeForLabel(): int
    {
        return self::$sizeForLabel;
    }

    private function calculateSizes(): self
    {
        $this->setSizeForElement(6);
        $this->setSizeForLabel(6);

        return $this;
    }
}
