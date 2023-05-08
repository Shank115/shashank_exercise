<?php

namespace Drupal\shashank_exercise\Controller; #defines namespace for controller

use Drupal\Core\Controller\ControllerBase; #class file importing
use Drupal\shashank_exercise\CustomService;

class Controller extends ControllerBase {  #controller class extension

public function exe() { #defining function
    $data = \Drupal::service('custom_service')->getName(); #calling the service
    return[
        '#theme'=> "shashank_template", #template use
        '#markup' => $data,    # returning data from service
        '#hexcode'=> '#FF0000', #color for the text
    ];
}

}
