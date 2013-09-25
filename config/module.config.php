<?php

return array(
    'controller_plugins' => array(
        'invokables' => array(
            'lemoFlashMessenger' => 'LemoBootstrap\Controller\Plugin\FlashMessenger',
        )
    ),
    'view_helpers' => array(
        'invokables' => array(
            'form'                  => 'LemoBootstrap\Form\View\Helper\Form',
            'formControlGroup'      => 'LemoBootstrap\Form\View\Helper\FormControlGroup',
            'formControlGroups'     => 'LemoBootstrap\Form\View\Helper\FormControlGroups',
            'formControlLabel'      => 'LemoBootstrap\Form\View\Helper\FormControlLabel',
            'formControls'          => 'LemoBootstrap\Form\View\Helper\FormControls',
            'formElement'           => 'LemoBootstrap\Form\View\Helper\FormElement',
            'formElementHelpBlock'  => 'LemoBootstrap\Form\View\Helper\FormElementHelpBlock',
            'formElementHelpInline' => 'LemoBootstrap\Form\View\Helper\FormElementHelpInline',
            'formLabel'             => 'LemoBootstrap\Form\View\Helper\FormLabel',
            'formRow'               => 'LemoBootstrap\Form\View\Helper\FormRow',
            'formRowElements'       => 'LemoBootstrap\Form\View\Helper\FormRowElements',
        )
    )
);
