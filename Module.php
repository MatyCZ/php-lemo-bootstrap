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
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
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
//                'flashMessanger'     => 'LemoBootstrap\View\Helper\FlashMessanger',
                'form'                  => 'LemoBootstrap\Form\View\Helper\Form',
                'formCollection'        => 'LemoBootstrap\Form\View\Helper\FormCollection',
                'formElement'           => 'LemoBootstrap\Form\View\Helper\FormElement',
                'formElementHelpBlock'  => 'LemoBootstrap\Form\View\Helper\FormElementHelpBlock',
                'formElementHelpInline' => 'LemoBootstrap\Form\View\Helper\FormElementHelpInline',
                'formLabel'             => 'LemoBootstrap\Form\View\Helper\FormLabel',
                'formRow'               => 'LemoBootstrap\Form\View\Helper\FormRow',
                'formRowElements'       => 'LemoBootstrap\Form\View\Helper\FormRowElements',
            )
        );
    }
}
