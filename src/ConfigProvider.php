<?php

declare(strict_types=1);

namespace Lemo\Bootstrap;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'view_helpers' => $this->getViewHelpers(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'invokables' => [
                Form\Form::class => Form\Form::class,
            ],
        ];
    }

    public function getViewHelpers(): array
    {
        return [
            'aliases' => [
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
            'invokables' => [
                Form\View\Helper\FormControl::class => Form\View\Helper\FormControl::class,
                Form\View\Helper\FormControlAddon::class => Form\View\Helper\FormControlAddon::class,
                Form\View\Helper\FormControlHelpBlock::class => Form\View\Helper\FormControlHelpBlock::class,
                Form\View\Helper\FormControlLabel::class => Form\View\Helper\FormControlLabel::class,
                Form\View\Helper\FormControls::class => Form\View\Helper\FormControls::class,
                Form\View\Helper\FormGroupElement::class => Form\View\Helper\FormGroupElement::class,
                Form\View\Helper\FormGroupElements::class => Form\View\Helper\FormGroupElements::class,
                Form\View\Helper\FormGroups::class => Form\View\Helper\FormGroups::class,
                Form\View\Helper\FormGroupsCollection::class => Form\View\Helper\FormGroupsCollection::class,
                Form\View\Helper\FormGroupsCollectionTemplate::class => Form\View\Helper\FormGroupsCollectionTemplate::class,
                Form\View\Helper\FormGroupsFieldset::class => Form\View\Helper\FormGroupsFieldset::class,
                Form\View\Helper\FormRenderOptions::class => Form\View\Helper\FormRenderOptions::class,
            ],
        ];
    }
}
