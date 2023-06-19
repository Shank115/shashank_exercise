<?php

namespace Drupal\shashank_exercise\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Returns responses for Custom Clone Title routes.
 */
class ControlNew extends ControllerBase {

  /**
   * The _title_callback for the node.clone route.
   *
   * @param \Drupal\node\Entity\Node $node
   *   The current node.
   *
   * @return string
   *   The page title.
   */
  public function nodTitle(Node $node) {
    if (!empty($node)) {
      $title = $node->getTitle();
      return [
        '#markup' => $title,
      ];
    }
    else {
      throw new NotFoundHttpException();
    }
  }

  /**
   * Function is called.
   */
  public function nodTitlePageTitle(Node $node) {
    $prepend_text = "Node of";
    return $prepend_text . $node->getTitle();
  }

  /**
   * Function is called.
   */
  public function accessNode(AccountInterface $account, $node) {
    $node = Node::load($node);
    $type = $node->getType();
    if ($type == 'article' || $type == 'page') {
      $result = AccessResult::allowed();
    }
    else {
      $result = AccessResult::forbidden();
    }

    $result->addCacheableDependency($node);

    return $result;
  }

}
