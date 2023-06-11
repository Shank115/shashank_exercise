<?php

namespace Drupal\shashank_exercise\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Define Class.
 */
class CustomForm extends FormBase {
  // Implements interface.

  /**
   * Generated form id.
   */
  public function getFormId() {
    // To get form id.
    // Form id.
    return 'custom_form_get_user_details';
  }

  /**
   * Build form generates form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Build form by adding fields.
    $form['firstname'] = [
    // Type of field.
      '#type' => 'textfield',
    // Title for field.
      '#title' => 'First Name',
    // Required field or not.
      '#required' => TRUE,
    // Placeholder for field.
      '#placeholder' => 'First Name',
    ];
    $form['lastname'] = [
      '#type' => 'textfield',
      '#title' => 'Last Name',
      '#required' => FALSE,
      '#placeholder' => 'Last Name',
    ];
    $form['email'] = [
      '#type' => 'textfield',
      '#title' => 'Email',
      '#default_value' => 'eg@eg.com',
    ];
    $form['dob'] = [
      '#type' => 'select',
      '#title' => 'Dob',
      '#options' => [
        'lessthan2k' => '<2000',
        '2k' => '2000',
        'morethan2k' => '>2000',

      ],
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
    ];
    // Displays form along with its fields.
    return $form;
  }

  /**
   * Submit form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Using messenger service to display the submitted message.
    \Drupal::messenger()->addMessage("User Details Submitted Successfully");
    // Using the insert to insert values into the database.
    \Drupal::database()->insert("user_details")->fields([
      'firstname' => $form_state->getValue("firstname"),
      'lastname' => $form_state->getValue("lastname"),
      'email' => $form_state->getValue("email"),
      'dob' => $form_state->getValue("dob"),
    ])->execute();
  }

}
