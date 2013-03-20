<?php

namespace LemoBootstrap\Form\View;

use Zend\ServiceManager\ConfigInterface;
use Zend\ServiceManager\ServiceManager;

class HelperConfig implements ConfigInterface
{
    /**
     * Pre-aliased view helpers
     *
     * @var array
     */
    protected $invokables = array(
        'form' => 'LemoBootstrap\Form\View\Helper\Form',
        'formElementHelp' => 'LemoBootstrap\Form\View\Helper\FormElementHelp',
        'formRow' => 'LemoBootstrap\Form\View\Helper\FormRow',
    );

    /**
     * Configure the provided service manager instance with the configuration
     * in this class.
     *
     * Adds the invokables defined in this class to the SM managing helpers.
     *
     * @param  ServiceManager $serviceManager
     * @return void
     */
    public function configureServiceManager(ServiceManager $serviceManager)
    {
        foreach ($this->invokables as $name => $service) {
            $serviceManager->setInvokableClass($name, $service);
        }
    }
}
