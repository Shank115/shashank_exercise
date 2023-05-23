<?php

namespace Drupal\shashank_exercise\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Define the "custom field type".
 *
 * @FieldType(
 *   id = "custom_field_type",
 *   label = @Translation("Custom Field Type"),
 *   description = @Translation("Desc for Custom Field Type"),
 *   category = @Translation("Text"),
 *   default_widget = "custom_field_widget",
 *   default_formatter = "custom_field_formatter",
 * )
 */

class CustomFieldType extends FieldItemBase {

    /**
     * {@inheritdoc}
     */

    public static function schema(FieldStorageDefinitionInterface $field_definition) { //this creates a table
        return [
            'columns' => [
                'value' => [
                    'type' => 'varchar',
                    'length' => $field_definition->getSetting("length"),
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function defaultStorageSettings() { //this is default settings for field
        return [
            'length' => 255, //length should be 255 or less than that
        ] + parent::defaultStorageSettings();
    }

    /**
     * {@inheritdoc}
     */
    public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
        $element = [];

        $element['length'] = [
            '#type' => 'number', //type of length field
            '#title' => t("Length of your text"), //title
            '#required' => TRUE,
            '#default_value' => $this->getSetting("length"), //default value
        ];
        return $element;
    }

    /**
     * {@inheritdoc}
     */
    public static function defaultFieldSettings() { //this is default
        return [
            'moreinfo' => "More info default value",
        ] + parent::defaultFieldSettings();
    }

    /**
     * {@inheritdoc}
     */
    public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
        $element = [];
        $element['moreinfo'] = [
            '#type' => 'textfield', //type of field
            '#title' => 'More information about this field', //title of field
            '#required' => TRUE, //is it required field
            '#default_value' => $this->getSetting("moreinfo"), //default value
        ];
        return $element;
    }

    /**
     * {@inheritdoc}
     */
    public static function PropertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
        $properties['value'] = DataDefinition::create('string')->setLabel(t("Name"));

        return $properties;
    }
}