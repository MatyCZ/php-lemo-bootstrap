<?php

declare(strict_types=1);

namespace Lemo\Bootstrap\Form\View\Helper;

use Laminas\View\HelperPluginManager;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final class FormGroupElementFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): FormGroupElement
    {
        /** @var HelperPluginManager $helperPluginManager */
        $helperPluginManager = $container->get(HelperPluginManager::class);

        return new FormGroupElement(
            $helperPluginManager->get(FormControlLabel::class),
            $helperPluginManager->get(FormControls::class),
        );
    }
}
