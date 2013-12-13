<?php

return array(
    'controller_plugins' => array(
        'invokables' => array(
            'lemoFlashMessenger' => 'LemoBootstrap\Controller\Plugin\FlashMessenger',
        )
    ),
    'view_helpers' => array(
        'invokables' => array(
            'htmlButton'            => 'LemoBootstrap\Html\View\Helper\HtmlButton',
            'htmlGlyphicon'         => 'LemoBootstrap\Html\View\Helper\HtmlGlyphicon',
            'formControl'           => 'LemoBootstrap\Form\View\Helper\FormControl',
            'formControlAddon'      => 'LemoBootstrap\Form\View\Helper\FormControlAddon',
            'formControlHelpBlock'  => 'LemoBootstrap\Form\View\Helper\FormControlHelpBlock',
            'formControlLabel'      => 'LemoBootstrap\Form\View\Helper\FormControlLabel',
            'formControls'          => 'LemoBootstrap\Form\View\Helper\FormControls',
            'formGroupElement'      => 'LemoBootstrap\Form\View\Helper\FormGroupElement',
            'formGroupElements'     => 'LemoBootstrap\Form\View\Helper\FormGroupElements',
            'formGroupsCollection'  => 'LemoBootstrap\Form\View\Helper\FormGroupsCollection',
            'formGroupsFieldset'    => 'LemoBootstrap\Form\View\Helper\FormGroupsFieldset',
        )
    )
);
