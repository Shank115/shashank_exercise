<?php

namespace Drupal\custom_drush\Commands;

use Consolidation\OutputFormatters\StructuredData\RowsOfFields;
use Drush\Commands\DrushCommands;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Define class.
 */
class DrushNodeTask extends DrushCommands {

  /**
   * Entity manager service.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityManager = $entityTypeManager;
    parent::__construct();
  }

  /**
   * Command that returns a list of all blocked users.
   *
   * @field-labels
   *  id: Node Id
   *  title: Title
   * @default-fields id,title
   *
   * @usage drush-helpers: return-title
   *   Returns all return-title
   *
   * @command drush-helpers:return-title
   * @aliases return-title
   */
  public function drushNode() {
    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'page']);
    $rows = [];
    foreach ($nodes as $node) {
      $rows[] = [
        'id' => $node->id(),
        'title' => $node->getTitle(),
      ];
    }
    return new RowsOfFields($rows);
  }

}
