<?php

/**
 * Class MailLog
 */
class MailLog extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $created_at;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $mail_sent;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $recipient;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $subject;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $additional_information;
}
