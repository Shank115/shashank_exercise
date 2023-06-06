<?php

namespace Drupal\custom_drush\Commands;

use Consolidation\OutputFormatters\StructuredData\RowsOfFields;
use Drush\Commands\DrushCommands;
use Drupal\Core\Entity\EntityTypeManagerInterface;

class DrushHelpersCommands extends DrushCommands {

  /**
   * @var Drupal\Core\Entity\EntityTypeManagerInterface $entityManager
   *    Entity manager service.
   */

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityManager = $entityTypeManager;
    parent::__construct();
  }

  /**
   * Command that returns a list of all blocked users.
   *
   * @field-labels
   *  id: User Id
   *  name: User Name
   *  email: User Email
   * @default-fields id,name,email
   *
   * @usage drush-helpers:blocked-users
   *   Returns all blocked users
   *
   * @command drush-helpers:blocked-users
   * @aliases blocked-users
   *
   * @return \Consolidation\OutputFormatters\StructuredData\RowsOfFields
   */
  public function blockedUsers() {
    $users = $this->entityManager->getStorage('user')->loadByProperties(['status' => 1]);
    $rows = [];
    foreach ($users as $user) {
      if ($user->id() != 0) {
        $rows[] = [
          'id' => $user->id(),
          'name' => $user->name->value,
          'email' => $user->mail->value,
        ];
      }
    }
    return new RowsOfFields($rows);
  }

}