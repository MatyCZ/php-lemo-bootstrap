<?php

namespace Lemo\Bootstrap\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Lemo\Bootstrap\Mvc\Controller\Plugin\FlashMessenger as FlashMessengerPlugin;

class FlashMessanger extends AbstractHelper
{
    /**
     * List of classes by namespace
     *
     * @var array
     */
    protected array $classMessages = [
        FlashMessengerPlugin::NAMESPACE_DEFAULT => 'alert alert-info',
        FlashMessengerPlugin::NAMESPACE_ERROR   => 'alert alert-danger',
        FlashMessengerPlugin::NAMESPACE_INFO    => 'alert alert-info',
        FlashMessengerPlugin::NAMESPACE_SUCCESS => 'alert alert-success',
        FlashMessengerPlugin::NAMESPACE_WARNING => 'alert alert-warning',
    ];

    /**
     * Render script with notices
     *
     * @param string|null $namespace
     * @return self
     */
    public function __invoke(?string $namespace = null): self
    {

        return $this;
    }

    /**
     * String representation
     *
     * @return string
     */
    public function render(): string
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
        }

        $xhtml[] = "Lemo_Alert.build('" .$message['type'] . "', '" .addslashes($message['title']) . "', '" .addslashes(str_replace("'", '`', $message['text'])) . "');";
        $xhtml[] = '</script>';

        return implode(PHP_EOL, $xhtml);
    }
}
