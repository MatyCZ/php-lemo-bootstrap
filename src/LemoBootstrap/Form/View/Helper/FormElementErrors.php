<?php

namespace LemoBootstrap\Form\View\Helper;

use Zend\Form\View\Helper\FormElementErrors as FormElementErrorsHelper;

class FormElementErrors extends FormElementErrorsHelper
{
    protected $messageCloseString     = '</span>';
    protected $messageOpenFormat      = '<span %s>';
    protected $messageSeparatorString = '<br />';
}
