<?php

namespace Drupal\custom_form\Form;


use Drupal\Core\Form\FormBase;
// To use as base class for customform.
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\InvokeCommand;

/**
 * Used for form.
 */
class CustomUserDetails extends FormBase {
  /**
   * The Messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;
  /**
   * The Messenger service.
   *
   * @var Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructs InviteByEmail .
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   * @param \Drupal\Core\Database\Connection $database
   *   The database service.
   */
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
   * Undocumented function.
   *
   * @return void
   *   Description for form.
   */
  public function getFormId() {
    return 'custom_get_user_details';
  }

  /**
   * Build form generates form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#attached']['library'][] = "shashank_exercise/jss_lib";
    // Creating a form with fields.
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => 'Name',
      '#required' => TRUE,
      '#placeholder' => 'name',
    ];
    $form['mail'] = [
      '#type' => 'textfield',
      '#title' => 'Email',
      '#placeholder' => 'abc@gmail.com',

    ];
    $form['gender'] = [
      '#type' => 'select',
      '#title' => 'Gender',
      '#options' => [
          'male' => 'Male',
          'female' => 'Female',
          'other' => 'Other'
      ],
  ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Save the configuration',
      '#ajax' => [
        'callback' => '::ajaxSubmit',
      ],
    ];

    return $form;
  }

  /**
   * Functiom.
   */
  public function ajaxSubmit() {
    $response = new AjaxResponse();
    $response->addCommand(new InvokeCommand("#custom_get_user_details", 'datacheck'));
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('name')) < 6) {
        $form_state->setErrorByname('name', "please make sure your username length is more than 5");
    }
}

  /**
   * Submit form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger->addStatus("thank you for submitting the form");
    $this->database->insert("user_det")->fields([
      'name' => $form_state->getValue("name"),
      'mail' => $form_state->getValue("mail"),
      'gender' => $form_state->getValue("gender"),
    ])->execute();
  }

}