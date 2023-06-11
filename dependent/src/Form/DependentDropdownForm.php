<?php

namespace Drupal\dependent\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Define a class.
 */
class DependentDropdownForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'dependent_dropdown_Form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Location stored in opt variable.
    $opt = $this->location();
    // Using getvalue to get the value of category and store it in cat.
    $cat = $form_state->getValue('category') ?: 'none';
    // Using getvalue to get the value of available items.
    $avai = $form_state->getValue('availableitems') ?: 'none';
    $form['category'] = [
    // Type is select.
      '#type' => 'select',
    // Providing the title.
      '#title' => 'country',
    // Options stored in opt variable.
      '#options' => $opt,
    // Default value.
      'default_value' => $cat,
      '#ajax' => [
    // Event.
        'callback' => '::DropdownCallback',
    // This element will get altered.
        'wrapper' => 'field-container',
    // Event is change.
        'event' => 'change',
      ],
    ];
    $form['availableitems'] = [
    // Type is select.
      '#type' => 'select',
    // Providing the title.
      '#title' => 'state',
    // Options stored in cat variable.
      '#options' => static::availableItems($cat),
    // F the form is empty get value from the available items.
      '#default_value' => !empty($form_state->getValue('availableitems')) ? $form_state->getValue('availableitems') : 'none',
    // Providing a prefix.
      '#prefix' => '<div id="field-container"',
    // Providing suffix.
      '#suffix' => '</div>',
      '#ajax' => [
    // This is event.
        'callback' => '::DropdownCallback',
    // Defining which element will get altered.
        'wrapper' => 'dist-container',
    // Event is change.
        'event' => 'change',
      ],
    ];
    $form['district'] = [
    // Type is select.
      '#type' => 'select',
    // Providing the title.
      '#title' => 'district',
    // Options stored in avai variable.
      '#options' => static::district($avai),
    // F the form is empty get value from the available items.
      '#default_value' => !empty($form_state->getValue('district')) ? $form_state->getValue('district') : '',
    // Providing a prefix.
      '#prefix' => '<div id="dist-container"',
    // Providing suffix.
      '#suffix' => '</div>',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Submit form this string is triggered and element stored on trigger.
    $trigger = (string) $form_state->getTriggeringElement()['#value'];
    // If it is not equal to submit.
    if ($trigger != 'submit') {
      // Rebuild the form state.
      $form_state->setRebuild();
    }
  }

  /**
   * Function dropdowncallback.
   */
  public function dropdownCallback(array &$form, FormStateInterface $form_state) {
    $triggering_element = $form_state->getTriggeringElement();
    $triggering_element_name = $triggering_element['#name'];

    // If element name is equal to category.
    if ($triggering_element_name === 'category') {
      // Return the values of available items.
      return $form['availableitems'];
    }
    // If element name is equal to available items.
    elseif ($triggering_element_name === 'availableitems') {
      // Return the district values.
      return $form['district'];
    }

  }

  /**
   * Function is called.
   */
  public function location() {
    // Setting the location values.
    return [
      'none' => '-none-',
      'india' => 'india',
    ];
  }

  /**
   * Function is called.
   */
  public function availableItems($cat) {
    switch ($cat) {
      case 'india':
        $opt = [
          'karnataka' => 'karnataka',
          'TN' => 'TN',
        ];
        break;

      default:
        $opt = ['none' => '-none-'];
        break;
    }
    return $opt;
  }

  /**
   * Function is called.
   */
  public function district($avai) {
    switch ($avai) {
      case 'karnataka':
        $opt = [
          'mysore' => 'mysore',
          'bangalore' => 'bangalore',
          'mangalore' => 'mangalore',
        ];
        break;

      case 'TN':
        $opt = [
          'chennai' => 'chennai',
          'madurai' => 'madurai',
        ];
        break;
    }
    return $opt;
  }

}
