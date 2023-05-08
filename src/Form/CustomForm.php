<?php

namespace Drupal\shashank_exercise\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class CustomForm extends FormBase {    #implements interface

    // generated form id
    public function getFormId()  #to get form id
    {
        return 'custom_form_get_user_details';  #form id
    }

    // build form generates form
    public function buildForm(array $form, FormStateInterface $form_state) {  #build form by adding fields
        $form['firstname'] = [
            '#type' => 'textfield',     #type of field
            '#title' => 'First Name',   #title for field
            '#required' => TRUE,        #required field or not
            '#placeholder' => 'First Name',   #placeholder for field
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
        return $form;        #displays form along with its fields
    }


    // submit form
    public function submitForm(array &$form, FormStateInterface $form_state) {
        \Drupal::messenger()->addMessage("User Details Submitted Successfully");  # using messenger service to display the submitted message
        \Drupal::database()->insert("user_details")->fields([        # using the insert to insert values into the database
            'firstname' => $form_state->getValue("firstname"),
            'lastname' => $form_state->getValue("lastname"),
            'email' => $form_state->getValue("email"),
            'dob' => $form_state->getValue("dob"),
        ])->execute();
    }
}