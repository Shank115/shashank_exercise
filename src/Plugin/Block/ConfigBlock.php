<?php

namespace Drupal\shashank_exercise\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides simple block for d4drupal.
 *
 * @Block (
 * id = "shashank_exercise",
 * admin_label = "Config Block"
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

/**
 * Provides a custom block with configuration form.
 *
 * @Block(
 *   id = "custom_config_block",
 *   admin_label = @Translation("Custom Block with Config Form"),
 * )
 */
class CustomBlockConfigBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The form builder.
   *
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected $formBuilder;

  /**
   * Constructs a new CustomBlockConfigBlock instance.
   *
   * @param array $configuration
   *   The block configuration.
   * @param string $plugin_id
   *   The plugin ID for the block.
   * @param mixed $plugin_definition
   *   The plugin definition for the block.
   * @param \Drupal\Core\Form\FormBuilderInterface $form_builder
   *   The form builder.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, FormBuilderInterface $form_builder) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->formBuilder = $form_builder;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('form_builder')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Get the configuration form.
    $form = \Drupal::formBuilder()->getForm('\Drupal\shashank_exercise\Form\ConfigForm');

    // Render the form.
    $rendered_form = \Drupal::service('renderer')->render($form);

    return [
      '#markup' => $rendered_form,
    ];
  }

}
