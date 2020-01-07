<?php

namespace LemoBootstrap\Mvc\Controller\Plugin;

use Laminas\Form\Form;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger as FlashMessengerPlugin;
use LemoBootstrap\Exception;

class FlashMessenger extends FlashMessengerPlugin
{
    /**
     * Warning messages namespace
     */
    const NAMESPACE_WARNING = 'warning';

    /**
     * Messages types
     */
    const TYPE_ERROR       = 'error';
    const TYPE_ERROR_FORM  = 'error';
    const TYPE_INFORMATION = 'information';
    const TYPE_SUCCESS     = 'success';
    const TYPE_WARNING     = 'warning';

    /**
     * List of allowed message types
     *
     * @var array
     */
    protected $allowedTypes = array(
        self::TYPE_ERROR,
        self::TYPE_ERROR_FORM,
        self::TYPE_INFORMATION,
        self::TYPE_SUCCESS,
        self::TYPE_WARNING
    );

    /**
     * Add new error message
     *
     * @param  string      $message
     * @param  string|null $title
     * @return FlashMessenger
     */
    public function addErrorMessage($message, $title = null)
    {
        if(null === $title) {
            $title = 'Error';
        }

        parent::addErrorMessage(array(
            'title' => $title,
            'message' => $message
        ));

        return $this;
    }

    /**
     * Add errors notices from form
     *
     * @param  Form $form
     * @return FlashMessenger
     */
    public function addFormErrorMessages(Form $form)
    {
        $formError = array();
        $messages = $form->getInputFilter()->getMessages();

        // Grab errors from fieldsets
        foreach($form->getFieldsets() as $fieldset) {
            $elements = $fieldset->getElements();
            foreach($fieldset->getInputFilter()->getMessages() as $errors) {
                foreach($errors as $element => $fieldsetMessages) {
                    if(isset($elements[$element])) {
                        foreach($fieldsetMessages as $message) {
                            $formError[$message][] = $elements[$element]->getLabel();
                        }
                    }
                }
            }

            unset($messages[$fieldset->getName()]);
        }

        // Grab errors from form
        $elements = $form->getElements();
        foreach($messages as $element => $errors) {
            foreach($errors as $message) {
                if(isset($elements[$element])) {
                    $formError[$message][] = $this->getController()
                        ->getServiceLocator()
                        ->get('Laminas\View\Renderer\PhpRenderer')
                        ->translate($elements[$element]->getLabel());
                }
            }
        }

        // Add error notices
        foreach($formError as $message => $elements) {
            sort($elements);

            parent::addErrorMessage(array(
                'title' => $message,
                'message' => implode(', ', $elements)
            ));
        }

        return $this;
    }

    /**
     * Add new information message
     *
     * @param  string      $message
     * @param  string|null $title
     * @return FlashMessenger
     */
    public function addInfoMessage($message, $title = null)
    {
        if(null === $title) {
            $title = 'Information';
        }

        parent::addInfoMessage(array(
            'title' => $title,
            'message' => $message
        ));

        return $this;
    }

    /**
     * Add new success message
     *
     * @param  string      $message
     * @param  string|null $title
     * @return FlashMessenger
     */
    public function addSuccessMessage($message, $title = null)
    {
        if(null === $title) {
            $title = 'Success';
        }

        parent::addSuccessMessage(array(
            'title' => $title,
            'message' => $message
        ));

        return $this;
    }

    /**
     * Add new warning message
     *
     * @param  string      $message
     * @param  string|null $title
     * @return FlashMessenger
     */
    public function addWarningMessage($message, $title = null)
    {
        if(null === $title) {
            $title = 'Warning';
        }

        $namespace = $this->getNamespace();
        $this->setNamespace(self::NAMESPACE_WARNING);
        $this->setNamespace($namespace);

        parent::addMessage(array(
            'title' => $title,
            'message' => $message
        ));

        return $this;
    }

    /**
     * Has warning messages?
     *
     * @return boolean
     */
    public function hasWarningMessages()
    {
        $namespace = $this->getNamespace();
        $this->setNamespace(self::NAMESPACE_WARNING);
        $hasMessages = $this->hasMessages();
        $this->setNamespace($namespace);

        return $hasMessages;
    }

    /**
     * Get warning messages
     *
     * @return array
     */
    public function getWarningMessages()
    {
        $namespace = $this->getNamespace();
        $this->setNamespace(self::NAMESPACE_WARNING);
        $messages = $this->getMessages();
        $this->setNamespace($namespace);

        return $messages;
    }

    /**
     * Add new message
     *
     * @param  string      $message
     * @param  string|null $title
     * @param  string      $type
     * @throws Exception\InvalidArgumentException
     * @return FlashMessenger
     */
    public function addMessage($message, $title = null, $type = SELF::TYPE_SUCCESS)
    {
        $type = strtolower($type);

        if(!in_array($type, $this->allowedTypes)) {
            throw new Exception\InvalidArgumentException(sprintf(
                "Invalid message type given. Only types '%s' are supported.",
                implode(', ', $this->allowedTypes)
            ));
        }

        // Set namespace to given type
        $this->setNamespace($type);

        // Create title
        if(null === $title) {
            $title = ucfirst($type);
        }

        parent::addMessage(array(
            'title' => $title,
            'message' => (string) $message,
        ));

        return $this;
    }
}
