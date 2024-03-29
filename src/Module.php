<?php

namespace Lemo\Bootstrap;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig(): array
    {
        $provider = new ConfigProvider();

        return [
            'service_manager' => $provider->getDependencies(),
            'view_helpers' => $provider->getViewHelpers(),
        ];
    }
}
