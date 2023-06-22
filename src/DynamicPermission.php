<?php

namespace Drupal\shashank_exercise;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\node\Entity\NodeType;

/**
 * Module permissions.
 */
class DynamicPermission {

  use StringTranslationTrait;

  /**
   * Returns an array of permissions.
   *
   * @return array
   *   The permissions.
   *
   * @see \Drupal\user\PermissionHandlerInterface::getPermissions()
   */
  public function dynamicPermission() {
    $perms = [];
    // Generate node permissions for all node types.
    foreach (NodeType::loadMultiple() as $type) {
      $type_id = $type->id();
      $type_params = ['%type' => $type->label()];
      $perms += [
        "clone $type_id perm" => [
          'title' => $this->t('%type: node permission', $type_params),
        ],
      ];
    }
    return $perms;
  }

}