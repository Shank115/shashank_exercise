<?php

namespace Drupal\dependent\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;

/**
 * Class for dropdown form.
 */
class DependentDropdownForm extends FormBase {

  /**
   * This is a comment. {@inheritdoc}.
   */
  public function getFormId() {
    return 'country_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $selected_country_id = $form_state->getValue("country");
    $selected_state_id = $form_state->getValue("state");
    // Create country form.
    $form['country'] = [
    // Type select.
      '#type' => 'select',
    // Title.
      '#title' => $this->t('Country'),
    // Returns state list.
      '#options' => $this->getCountryOptions(),
      '#empty_option' => $this->t('- Select -'),
      '#ajax' => [
        'callback' => [$this, 'ajaxStateDropdownCallback'],
        'wrapper' => 'state-dropdown-wrapper',
        'event' => 'change',
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Loading...'),
        ],
      ],
    ];

    $form['state'] = [
      '#type' => 'select',
      '#title' => $this->t('State'),
      '#options' => $this->getstateOptions($selected_country_id),
      '#empty_option' => $this->t('- Select -'),
      '#prefix' => '<div id="state-dropdown-wrapper">',
      '#suffix' => '</div>',
      '#ajax' => [
        'callback' => [$this, 'ajaxDistrictDropdownCallback'],
        'wrapper' => 'district-dropdown-wrapper',
        'event' => 'change',
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Loading...'),
        ],
      ],
    ];

    $form['district'] = [
      '#type' => 'select',
      '#title' => $this->t('District'),
      '#options' => $this->getDistrictsByState($selected_state_id),
      '#prefix' => '<div id="district-dropdown-wrapper">',
      '#suffix' => '</div>',
      '#empty_option' => $this->t('- Select -'),
    ];
    // Submitting the form.
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
    // Handle form submission if needed.
  }

  /**
   * Ajax callback for the state dropdown.
   */
  public function ajaxStateDropdownCallback(array &$form, FormStateInterface $form_state) {
    return $form['state'];
  }

  /**
   * Ajax callback for the district dropdown.
   */
  public function ajaxDistrictDropdownCallback(array &$form, FormStateInterface $form_state) {
    return $form['district'];
  }

  /**
   * Helper function to retrieve country options.
   */
  private function getCountryOptions() {
    $query = Database::getConnection()->select('country', 'c');
    $query->fields('c', ['id', 'name']);
    $result = $query->execute();
    $options = [];

    foreach ($result as $row) {
      $options[$row->id] = $row->name;
    }

    return $options;
  }

  /**
   * Function is called.
   */
  private function getstateOptions($selected_country_id) {

    // Fetch the states for the selected country.
    $query = Database::getConnection()->select('state', 's');
    $query->fields('s', ['id', 'name']);
    $query->condition('s.country_id', $selected_country_id);
    $result = $query->execute();

    // Iterate over the result to retrieve the state information.
    $states = [];
    foreach ($result as $row) {
      $states[$row->id] = $row->name;
    }
    return $states;
  }

  /**
   * Function is called.
   */
  public function getDistrictsByState($selected_state_id) {
    $query = Database::getConnection()->select('district', 'd');
    $query->fields('d', ['id', 'name']);
    $query->condition('d.state_id', $selected_state_id);
    $result = $query->execute();

    $districts = [];
    foreach ($result as $row) {
      $districts[$row->id] = $row->name;
    }

    return $districts;
  }

}
