<?php

declare(strict_types=1);

namespace Lemo\Bootstrap\Form\View\Helper;

use Laminas\View\HelperPluginManager;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final class FormControlsFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): FormControls
    {
        /** @var HelperPluginManager $helperPluginManager */
        $helperPluginManager = $container->get(HelperPluginManager::class);

        return new FormControls(
            $helperPluginManager->get(FormControl::class),
        );
    }
}
