<?php

use Phalcon\Mvc\Controller;

/**
 * Class ControllerBase
 */
class ControllerBase extends Controller
{
    public function beforeExecuteRoute()
    {
        // use the factory to create a Faker\Generator instance
        /*    $faker = Faker\Factory::create();
    
            echo $faker->text;
            */
        // $this->profiler->start(Faker\Factory::create());

        //$this->logger->warning('This is a warning!', ['some' => 'context']);

        //        $this->db->query('SELECT * FROM test');

       // echo '<pre>';
        //print_r($_SERVER);
        ///die;

        //Test::find();
      //  echo $this->faker->words(3, true);

          $this->mail->Username = 'rrrr';


    }
}
