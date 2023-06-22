<?php

namespace Drupal\shashank_exercise\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * For custom form.
 */
class ValForm extends FormBase {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * CustomForm constructor.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_form_get_user_details';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Building form by adding the required fields.
    $form['firstname'] = [
      '#type' => 'textfield',
      '#title' => 'First Name',
      '#required' => TRUE,
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

    return $form;
  }
  /**
  * {@inheritdoc}
  */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $email = $form_state->getValue('email');

    if (empty($email)) {
      $form_state->setErrorByName('email', $this->t('Email is required.'));
    }
    elseif (!preg_match('/^[\w\-\.]+@[\w\-\.]+\.\w+$/', $email)) {
      $form_state->setErrorByName('email', $this->t('The email address you entered is incorrect.'));
    }
  }
  /**
   * Submit form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Using messenger service to display the submitted message.
    \Drupal::messenger()->addMessage("User Details Submitted Successfully");
    // Using the insert to insert values into the database.
    // \Drupal::database()->insert("user_details")->fields([
    //   'firstname' => $form_state->getValue("firstname"),
    //   'lastname' => $form_state->getValue("lastname"),
    //   'email' => $form_state->getValue("email"),
    //   'dob' => $form_state->getValue("dob"),
    // ])->execute();
  }

}
