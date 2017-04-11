<?php
namespace Library;

/**
 * Class Response
 */
class Response extends \Phalcon\Http\Response
{
    private $di;

    /**
     * Response constructor.
     * @param \Phalcon\Di\FactoryDefault $di
     */
    public function __construct(\Phalcon\Di\FactoryDefault $di)
    {
        parent::__construct();
        $this->di = $di;
    }

    /**
     * @param string        $redirectTo
     * @param string|array  $messages
     * @param string        $messageType
     * @return mixed
     */
    public function redirectWithMessage(string $redirectTo, $messages, $messageType = 'error')
    {
        $messageType = in_array($messageType, ['success', 'notice', 'info', 'error']) ? $messageType : 'error';
        $messages = is_string($messages) ? [$messages] : $messages;

        $flashSession = $this->di->get('flashSession');
        $flashSession->clear();

        foreach($messages as $message)
        {
            if(empty($message))
            {
                continue;
            }

            $flashSession->{$messageType}($message);
        }

        $this->di->get('view')->disable();
        return $this->di->get('response')->redirect($redirectTo);
    }
}