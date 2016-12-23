<?php

return array(
    'controller_plugins' => array(
        'invokables' => array(
            'lemoFlashMessenger' => 'LemoBootstrap\Controller\Plugin\FlashMessenger',
        )
    ),
    'view_helpers' => array(
        'invokables' => array(
            'htmlButton'             => 'LemoBootstrap\Html\View\Helper\HtmlButton',
            'htmlFontAwesome'        => 'LemoBootstrap\Html\View\Helper\HtmlFontAwesome',
            'htmlGlyphicon'          => 'LemoBootstrap\Html\View\Helper\HtmlGlyphicon',
            'formCaptchaImage'       => 'LemoBootstrap\Form\View\Helper\Captcha\Image',
            'formControl'            => 'LemoBootstrap\Form\View\Helper\FormControl',
            'formControlAddon'       => 'LemoBootstrap\Form\View\Helper\FormControlAddon',
            'formControlHelpBlock'   => 'LemoBootstrap\Form\View\Helper\FormControlHelpBlock',
            'formControlLabel'       => 'LemoBootstrap\Form\View\Helper\FormControlLabel',
            'formControls'           => 'LemoBootstrap\Form\View\Helper\FormControls',
            'formGroupElement'       => 'LemoBootstrap\Form\View\Helper\FormGroupElement',
            'formGroupElements'      => 'LemoBootstrap\Form\View\Helper\FormGroupElements',
            'formGroups'             => 'LemoBootstrap\Form\View\Helper\FormGroups',
            'formGroupsCollection'   => 'LemoBootstrap\Form\View\Helper\FormGroupsCollection',
            'formGroupsFieldset'     => 'LemoBootstrap\Form\View\Helper\FormGroupsFieldset',
            'formRenderOptions'      => 'LemoBootstrap\Form\View\Helper\FormRenderOptions',
            'formTemplateCollection' => 'LemoBootstrap\Form\View\Helper\FormTemplateCollection',
        )
    )
);
