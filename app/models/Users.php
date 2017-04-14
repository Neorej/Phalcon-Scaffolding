<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email          as EmailValidator;
use Phalcon\Validation\Validator\Uniqueness     as UniquenessValidator;
use Phalcon\Validation\Validator\StringLength   as StringLengthValidator;

use \Phalcon\Mvc\Model\Relation as Relation;

/**
 * Class Users
 */
class Users extends \Phalcon\Mvc\Model
{
    public $id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $name;

    /**
     *
     * @var string
     * @Column(type="string", length=254, nullable=false)
     */
    public $email;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $password;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $email_confirmed;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $is_admin;

    /**
     * Set up model relations
     */
    public function initialize()
    {
        $this->hasMany('id', 'EmailConfirmations', 'user_id',[
            'foreignKey' => [
                'action' => Relation::ACTION_CASCADE,
            ]
        ]);

        $this->hasMany('id', 'PasswordResets', 'user_id',[
            'foreignKey' => [
                'action' => Relation::ACTION_CASCADE,
            ]
        ]);
    }

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email',
            new UniquenessValidator([
                'model'   => $this,
                'message' => 'This email address is already in use',
            ])
        );

        $validator->add(
            'email',
            new EmailValidator([
                'message' => 'Please enter a correct email address',
            ])
        );

        $validator->add(
            'name',
            new StringLengthValidator([
                'min'            => 2,
                'max'            => 255,
                'messageMinimum' => 'Names must be at least 2 characters',
                'messageMaximum' => 'Names are limited to 255 characters',
            ])
        );

        $validator->add(
            'password',
            new StringLengthValidator([
                'min'            => 8,
                'messageMinimum' => 'Passwords must be at least 8 characters',
            ])
        );

        return $this->validate($validator);
    }

    public function beforeCreate()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    
    public function afterCreate()
    {
        $this->createNewEmailConfirmation();
    }

    /**
     * 
     */
    public function createNewEmailConfirmation()
    {
        $email_confirmation = new EmailConfirmations();
        $email_confirmation->user_id = $this->id;
        $email_confirmation->save();
    }

    /**
     *
     */
    public function createNewPasswordReset()
    {
        $password_reset = new PasswordResets();
        $password_reset->user_id = $this->id;
        $password_reset->save();
    }
    
}
