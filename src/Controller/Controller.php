<?php

namespace Drupal\shashank_exercise\Controller;

// Class file importing.
use Drupal\Core\Controller\ControllerBase;

/**
 * Define class.
 */
class Controller extends ControllerBase {

  /**
   * Controller class extension.
   */
  public function exe() {
    // Defining function.
    // Calling the service.
    $data = \Drupal::service('custom_service')->getName();
    return [
    // Template use.
      '#theme' => "shashank_template",
    // Returning data from service.
      '#markup' => $data,
    // Color for the text.
      '#hexcode' => '#FF0000',
    ];
  }

}
