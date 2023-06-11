<?php

namespace Drupal\shashank_exercise\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides simple block for d4drupal.
 *
 * @Block (
 * id = "shashank_exercise",
 * admin_label = "Config Plugin Block"
 * )
 */
class ConfigBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Render function.
    $form = \Drupal::formBuilder()->getForm('\Drupal\shashank_exercise\Form\ConfigForm');
    return $form;

  }

}
