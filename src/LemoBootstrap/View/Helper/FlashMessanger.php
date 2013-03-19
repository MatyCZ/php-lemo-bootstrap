<?php

namespace LemoBootstrap\View\Helper;

use LemoBootstrap\Mvc\Controller\Plugin\FlashMessenger as FlashMessengerPlugin;
use Zend\View\Helper\AbstractHelper;

class FlashMessanger extends AbstractHelper
{
    /**
     * List of classes by namespace
     *
     * @var array
     */
    protected $classMessages = array(
        FlashMessengerPlugin::NAMESPACE_DEFAULT => 'alert alert-info',
        FlashMessengerPlugin::NAMESPACE_ERROR   => 'alert alert-error',
        FlashMessengerPlugin::NAMESPACE_INFO    => 'alert alert-info',
        FlashMessengerPlugin::NAMESPACE_SUCCESS => 'alert alert-success',
        FlashMessengerPlugin::NAMESPACE_WARNING => 'alert alert-warning',
    );

    /**
     * Render script with notices
     *
     * @return string
     */
    public function __invoke($namespace = null)
    {

        return $this;
    }

    /**
     * String representation
     *
     * @return string
     */
    public function render()
    {
        if(!$this->_notice->hasMessages()) {
            return '';
        }

        $xhtml[] = '<script type="text/javascript">';

        foreach($this->_notice->getMessages() as $message) {
            $message['title'] = $this->getTitlePrependString() . $message['title'] . $this->getTitleAppendString();

            if(NoticeControllerPlugin::ERROR_FORM != $message['type']) {
                $message['text'] = $this->getTextPrependString() . $message['text'] . $this->getTextAppendString();
            }

            if($this->_translate) {
                $message['title'] = $this->getView()->translate($message['title']);

                if(NoticeControllerPlugin::ERROR_FORM != $message['type']) {
                    $message['text'] = $this->getView()->translate($message['text']);
                }
            }

            $script[] = "	$.notice({";
            $script[] = "		type: '" . $message['type'] . "',";
            $script[] = "		title: '" . $message['title'] . "',";
            $script[] = "		text: '" . str_replace("'", '`', $message['text']) . "'";
            $script[] = "	});";
        }

        $xhtml[] = implode(PHP_EOL, $script);
        $xhtml[] = '</script>';

        return implode(PHP_EOL, $xhtml);
    }
}
