<?php
namespace Library;

/**
 * Class Mail
 */
Class Mail extends \Phalcon\Mvc\User\Component
{
    public $phpMailer;

    /**
     * Mail constructor.
     * @param \Phalcon\Config $config
     */
    public function __construct(\Phalcon\Config $config)
    {
        $this->phpMailer = new \PHPMailer();
        $this->phpMailer->isHTML();
        $this->phpMailer->isSMTP();
        $this->phpMailer->SMTPAuth = true;

        //$this->phpMailer->->SMTPSecure = "ssl";
        //$this->phpMailer->WordWrap = 50;

        foreach($config as $property => $value)
        {
            $this->phpMailer->{$property} = $value;
        }
    }

    /**
     * @param string $recipient_email
     * @param string $recipient_name
     * @param string $subject
     * @param string $body
     * @return bool
     */
    public function sendMail(string $recipient_email, string $recipient_name, string $subject, string $body) : bool
    {
        $this->phpMailer->Subject = $subject;
        $this->phpMailer->MsgHTML($body);
        $this->phpMailer->AddAddress($recipient_email, $recipient_name);

        $is_sent = $this->phpMailer->Send();

        // Clean up after sending
        $this->phpMailer->ClearAddresses();
        $this->phpMailer->ClearAttachments();

        // Log the mail in the database
        $mail_log = new \MailLog();
        $mail_log->created_at             = time();
        $mail_log->mail_sent              = (int) $is_sent;
        $mail_log->recipient              = $recipient_email;
        $mail_log->subject                = $this->phpMailer->Subject;
        $mail_log->additional_information = $this->phpMailer->ErrorInfo;
        $mail_log->save();

        return $is_sent;
    }
}