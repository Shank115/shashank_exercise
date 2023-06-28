<?php

namespace Drupal\shashank_exercise\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Messenger\MessengerInterface;


/**
 * For custom form.
 */
class CustomForm extends FormBase {


  protected $messenger;
  /**
   * The Messenger service.
   *
   * @var Drupal\Core\Database\Connection
   */
  protected $database;

  public function __construct(MessengerInterface $messenger, Connection $database) {
    $this->messenger = $messenger;
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('messenger'),
      $container->get('database'),
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
   * Submit form.
   */
    public function submitForm(array &$form, FormStateInterface $form_state) {
      // Using a message service to display
      $this->messenger->addStatus("form submitted");
      // Using a service of database to store datas submitted.
      $this->database->insert("custom_form")->fields([
      'firstname' => $form_state->getValue("firstname"),
      'lastname' => $form_state->getValue("lastname"),
      'email' => $form_state->getValue("email"),
      'dob' => $form_state->getValue("dob"),
    ])->execute();
  }

}


