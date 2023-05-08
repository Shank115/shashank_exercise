<?php


namespace Drupal\shashank_exercise\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;
use Drupal\custom_task\Form\CustomForm;

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

    $form = \Drupal::formBuilder()->getForm('Drupal\shashank_exercise\Form\CustomForm');  #rendered custom form using formBuilder()

    return $form; #renders form in a block
   }
}