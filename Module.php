<?php

namespace LemoBootstrap;

use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerPluginProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, ControllerPluginProviderInterface, ViewHelperProviderInterface
{
    /**
     * @inheritdoc
     */
    public function getAutoloaderConfig()
    {
        return array(
            AutoloaderFactory::STANDARD_AUTOLOADER => array(
                StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    /**
     * @inheritdoc
     */
    public function getConfig($env = null)
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @inheritdoc
     */
    public function getControllerPluginConfig()
    {
        return array(
            'invokables' => array(
                'lemoFlashMessenger' => 'LemoBootstrap\Controller\Plugin\FlashMessenger',
            ),
        );
    }

    /**
     * @inheritdoc
     */
    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
                'lemoFlashMessanger' => 'BcomCrm\View\Helper\FlashMessanger',
                'form'               => 'LemoBootstrap\Form\View\Helper\Form',
                'formElementHelp'    => 'LemoBootstrap\Form\View\Helper\FormElementHelp',
                'formRow'            => 'LemoBootstrap\Form\View\Helper\FormRow',
            )
        );
    }
}
