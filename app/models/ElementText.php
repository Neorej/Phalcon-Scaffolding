<?php

/**
 * Class ElementText
 */
class ElementText extends \Phalcon\Mvc\Model
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
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $text_value;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $last_edited;
}
