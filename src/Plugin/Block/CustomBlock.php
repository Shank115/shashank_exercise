<?php

namespace Drupal\shashank_exercise\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Custom' block.
 *
 * @Block(
 *   id = "custom_task",
 *   admin_label = "Shashank block",
 * )
 */
class CustomBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    // Rendered custom form using formBuilder()
    $form = \Drupal::formBuilder()->getForm('Drupal\shashank_exercise\Form\CustomForm');

    // Renders form in a block.
    return $form;
  }

}
