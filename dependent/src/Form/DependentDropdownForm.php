<?php

namespace Drupal\dependent\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;


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
    $opt = $this->location(); #location stored in opt variable
    $cat = $form_state->getValue('category') ?: 'none';  #using getvalue to get the value of category and store it in cat
    $avai = $form_state->getValue('availableitems') ?: 'none'; #using getvalue to get the value of available items
    $form['category'] = [
        '#type' => 'select', #type is select
        '#title' => 'country',  #providing the title
        '#options' => $opt,   #options stored in opt variable
        'default_value' => $cat,  #default value
        '#ajax' => [
            'callback' => '::DropdownCallback',  #event
            'wrapper' => 'field-container',   #this element will get altered
            'event' => 'change'   #event is change
        ]
    ];
    $form['availableitems'] = [
        '#type' => 'select',   #type is select
        '#title' => 'state',  #providing the title
        '#options' =>static::availableItems($cat), #options stored in cat variable
        '#default_value' => !empty($form_state->getValue('availableitems')) ? $form_state->getValue('availableitems') : 'none',   #f the form is empty get value from the available items
        '#prefix' => '<div id="field-container"',  #providing a prefix
        '#suffix' => '</div>',  #providing suffix
        '#ajax' => [
          'callback' => '::DropdownCallback',   #this is event
          'wrapper' => 'dist-container',   #defining which element will get altered
          'event' => 'change'    #event is change
      ]
    ];
    $form['district'] = [
          '#type' => 'select',   #type is select
          '#title' => 'district', #providing the title
          '#options' =>static::district($avai), #options stored in avai variable
          '#default_value' => !empty($form_state->getValue('district')) ? $form_state->getValue('district') : '',   #f the form is empty get value from the available items
          '#prefix' => '<div id="dist-container"',   #providing a prefix
          '#suffix' => '</div>',   #providing suffix
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
    $trigger = (string) $form_state->getTriggeringElement()['#value'];  #submit form this string is triggered and element stored on trigger
    if ($trigger != 'submit') {   #if it is not equal to submit
        $form_state->setRebuild();  #rebuild the form state
    }
  }

  public function DropdownCallback(array &$form, FormStateInterface $form_state) {
    $triggering_element = $form_state->getTriggeringElement();
    $triggering_element_name = $triggering_element['#name'];

    if ($triggering_element_name === 'category') {  #if element name is equal to category
      return $form['availableitems'];  #return the values of available items
    }
    elseif ($triggering_element_name === 'availableitems') {  #if element name is equal to available items
      return $form['district'];   #return the district values
    }


  }

  public function location() {   #setting the location values
    return [
        'none' => '-none-',
        'india' => 'india',
    ];
  }

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

  public function district($avai) {
    switch($avai) {
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