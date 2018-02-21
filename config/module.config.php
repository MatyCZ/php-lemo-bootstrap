<?php

return [
    'controller_plugins' => [
        'invokables' => [
            'lemoFlashMessenger' => \LemoBootstrap\Mvc\Controller\Plugin\FlashMessenger::class,
        ],
    ],
    'view_helpers'       => [
        'invokables' => [
            'formCaptchaImage'             => \LemoBootstrap\Form\View\Helper\Captcha\Image::class,
            'formControl'                  => \LemoBootstrap\Form\View\Helper\FormControl::class,
            'formControlAddon'             => \LemoBootstrap\Form\View\Helper\FormControlAddon::class,
            'formControlHelpBlock'         => \LemoBootstrap\Form\View\Helper\FormControlHelpBlock::class,
            'formControlLabel'             => \LemoBootstrap\Form\View\Helper\FormControlLabel::class,
            'formControls'                 => \LemoBootstrap\Form\View\Helper\FormControls::class,
            'formGroupElement'             => \LemoBootstrap\Form\View\Helper\FormGroupElement::class,
            'formGroupElements'            => \LemoBootstrap\Form\View\Helper\FormGroupElements::class,
            'formGroups'                   => \LemoBootstrap\Form\View\Helper\FormGroups::class,
            'formGroupsCollection'         => \LemoBootstrap\Form\View\Helper\FormGroupsCollection::class,
            'formGroupsCollectionTemplate' => \LemoBootstrap\Form\View\Helper\FormGroupsCollectionTemplate::class,
            'formGroupsFieldset'           => \LemoBootstrap\Form\View\Helper\FormGroupsFieldset::class,
            'formRenderOptions'            => \LemoBootstrap\Form\View\Helper\FormRenderOptions::class,
        ],
    ],
];
