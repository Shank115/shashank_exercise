<?php

namespace Drupal\shashank_exercise;

use Drupal\Core\Config\ConfigFactory;

/**
 * Class CustomService.
 *
 * @package Drupal\shashank_exercise\Services
 */
class CustomService {

  /**
   * Configuration Factory.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $configFactory;

  /**
   * Constructor.
   */
  public function __construct(ConfigFactory $configFactory) {
    $this->configFactory = $configFactory;
  }

  /**
   * Gets my setting.
   */
  public function getName() {     #takes value of name and returns it
    $config = $this->configFactory->get('shashank_exercise.settings');
    return $config->get('name');  #return the value
  }

}