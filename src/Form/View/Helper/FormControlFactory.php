<?php

declare(strict_types=1);

namespace Lemo\Bootstrap\Form\View\Helper;

use Laminas\Form\View\Helper\FormElement;
use Laminas\View\HelperPluginManager;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final class FormControlFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): FormControl
    {
        /** @var HelperPluginManager $helperPluginManager */
        $helperPluginManager = $container->get(HelperPluginManager::class);

        return new FormControl(
            $helperPluginManager->get(FormControlAddon::class),
            $helperPluginManager->get(FormControlButton::class),
            $helperPluginManager->get(FormControlHelpBlock::class),
            $helperPluginManager->get(FormElement::class),
        );
    }
}
