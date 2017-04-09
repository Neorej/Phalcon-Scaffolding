<?php

/**
 * Class EmailConfirmations
 */
class EmailConfirmations extends \Phalcon\Mvc\Model
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
    public $user_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $confirmation_code;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $created_at;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $confirmed_at;

    /**
     * @param int $user_id
     */
    public function initialize(int $user_id) : void
    {
        $this->user_id = $user_id;
        $this->confirmation_code = (new \Phalcon\Security\Random())->uuid;
        $this->created_at = time();
        $this->save();
    }

    public function confirm()
    {

    }

    public function invalidate()
    {
        
    }
}
