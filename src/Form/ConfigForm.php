<?php

namespace Drupal\shashank_exercise\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Define class.
 */
class ConfigForm extends ConfigFormBase {

  /**
   * Settings Variable.
   */
  // Defines php constant.
  const CONFIGNAME = "shashank_exercise.settings";

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    // Returns form id.
    return "shashank_exercise.settings";
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    // This function returns array of configform objects.
    return [
      static::CONFIGNAME,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Creates form field.
    // Used to load configform object then to modify & retrieve data.
    $config = $this->config(static::CONFIGNAME);
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => '<span>Name</span>',
      '#attached' => [
        'library' => [
          'shashank_exercise/shank_lib',
        ],
      ],
      // Gives the default value.
      '#default_value' => $config->get("name"),
    ];

    // Add another field.
    $form['email'] = [
      '#type' => 'textfield',
      '#title' => '<span>email</span>',
      '#attached' => [
    // Using span here and attached library to get color from style.css.
        'library' => [
          'shashank_exercise/shank_lib',
        ],
      ],
      '#default_value' => $config->get("email"),
    ];

    // Returns the form.
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Function for submit form.
    $config = $this->config(static::CONFIGNAME);
    // Setting the value of a config key to the value submitted in a form field.
    $config->set("name", $form_state->getValue('name'));
    $config->set("email", $form_state->getValue('email'));
    // To save the form value.
    $config->save();
  }

}
