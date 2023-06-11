<?php

namespace Drupal\shashank_exercise;

use Drupal\Core\Config\ConfigFactory;

/**
 * ASd.
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
  public function getName() {
    // Takes value of name and returns it.
    $config = $this->configFactory->get('shashank_exercise.settings');
    // Return the value.
    return $config->get('name');
  }

}
