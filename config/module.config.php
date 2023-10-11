<?php

namespace Lemo\Bootstrap;

return [
    'view_helpers' => [
        'invokables' => [
            'formCaptchaImage' => Form\View\Helper\Captcha\Image::class,
            'formControl' => Form\View\Helper\FormControl::class,
            'formControlAddon' => Form\View\Helper\FormControlAddon::class,
            'formControlHelpBlock' => Form\View\Helper\FormControlHelpBlock::class,
            'formControlLabel' => Form\View\Helper\FormControlLabel::class,
            'formControls' => Form\View\Helper\FormControls::class,
            'formGroupElement' => Form\View\Helper\FormGroupElement::class,
            'formGroupElements' => Form\View\Helper\FormGroupElements::class,
            'formGroups' => Form\View\Helper\FormGroups::class,
            'formGroupsCollection' => Form\View\Helper\FormGroupsCollection::class,
            'formGroupsCollectionTemplate' => Form\View\Helper\FormGroupsCollectionTemplate::class,
            'formGroupsFieldset' => Form\View\Helper\FormGroupsFieldset::class,
            'formRenderOptions' => Form\View\Helper\FormRenderOptions::class,
        ],
    ],
];
