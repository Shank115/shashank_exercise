<?php

namespace Drupal\shashank_exercise\Controller;

// Base class for controller.
use Drupal\Core\Controller\ControllerBase;
use Drupal\shashank_exercise\CustomService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * To include custom_service.
 */
class Controllers extends ControllerBase {
  /**
   * The customservice.
   *
   * @var \Drupal\shashank_exercise\CustomService
   */
  protected $customService;

  /**
   * Dependency injection.
   */
  public static function create(ContainerInterface $container) {
    return new static(
    $container->get('custom_service')
    );
  }

  /**
   * Constructor.
   */
  public function __construct(CustomService $customService) {
    $this->customService = $customService;
  }

  /**
   * Provides the node submission form.
   *
   * @return array
   *   A node submission form.
   */
  public function exe() {
    // Defining function.
    $data = $this->customService->getName();
    return [
    // Rendering the template.
      '#theme' => 'shashank_template',
    // Value is passed.
      '#markup' => $data,
    // Color.
      '#hexcode' => '#FF0000',
    ];
  }

}
