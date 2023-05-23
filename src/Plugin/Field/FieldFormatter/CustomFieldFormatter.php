<?php

namespace Drupal\shashank_exercise\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;


/**
 * Define the "custom field formatter".
 *
 * @FieldFormatter(
 *   id = "custom_field_formatter",
 *   label = @Translation("Custom Field Formatter"),
 *   description = @Translation("Desc for Custom Field Formatter"),
 *   field_types = {
 *     "custom_field_type"
 *   }
 * )
 */


class CustomFieldFormatter extends FormatterBase {

    /**
     * {@inheritdoc}
     */
    public static function defaultSettings() { //default function
        return [
            'concat' => 'Concat with ', //message will be displayed in manage display infront of field
        ] + parent::defaultSettings();
    }

    /**
     * {@inheritdoc}
     */

    public function settingsForm(array $form, FormStateInterface $form_state) {
        $form['concat'] =[
            '#type' => 'textfield', //type of concat field
            '#title' => 'Concatenate with', //title
            '#default_value' => $this->getSetting('concat'), //default value
        ];
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function settingsSummary() {
        $summary = [];
        $summary[] = $this->t("concatenate with : @concat", ["@concat" => $this->getSetting('concat')]); //@concat gets value of concat
        return $summary;
    }

    /**
     * {@inheritdoc}
     */

     public function viewElements(FieldItemListInterface $items, $langcode) {
        $element = [];

        foreach ( $items as $delta => $item) {
            $element[$delta] = [
                '#markup' => $this->getSetting('concat') . $item->value,
            ];
        }
        return $element;
     }

}