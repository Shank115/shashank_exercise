<?php

namespace Drupal\shashank_exercise\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class ConfigForm extends ConfigFormBase {

    /**
     * Settings Variable.
     */
    Const CONFIGNAME = "shashank_exercise.settings"; #defines php constant

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return "shashank_exercise.settings"; #returns form id
    }

    /**
     * {@inheritdoc}
     */

    protected function getEditableConfigNames() { #this function returns array of configform objects
        return [
            static::CONFIGNAME,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) { #creates form field
        $config = $this->config(static::CONFIGNAME); #used to load configform object then to modify & retrieve data
        $form['name'] = [
            '#type' => 'textfield',
            '#title' => '<span>Name</span>',
            '#attached' => [
                'library' => [
                    'shashank_exercise/shank_lib',
                ],
            ],
            '#default_value' => $config->get("name"), #gives the default value
        ];

        $form['email'] = [             #add another field
            '#type' => 'textfield',
            '#title' => '<span>email</span>',
            '#attached' => [
                'library' => [             #using span here and attached library to get color from style.css
                    'shashank_exercise/shank_lib',
                ],
            ],
            '#default_value' => $config->get("email"),
        ];

        return Parent::buildForm($form, $form_state); #returns the form
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) { #function for submit form
        $config = $this->config(static::CONFIGNAME);
        $config->set("name", $form_state->getValue('name')); #setting the value of a config key to the value submitted in a form field
        $config->set("email", $form_state->getValue('email'));
        $config->save();        #to save the form value
    }

}