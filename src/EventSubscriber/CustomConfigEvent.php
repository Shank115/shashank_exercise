<?php

namespace Drupal\shashank_exercise\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Config\ConfigEvents;
use Drupal\Core\Config\ConfigCrudEvent;
use Drupal\Core\Messenger\MessengerInterface;

/**
 * Class CustomConfigEventSubscriber.
 *
 * Description for the class.
 */
class CustomConfigEvent implements EventSubscriberInterface {
  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * CustomConfigEventSubscriber constructor.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   */
  public function __construct(MessengerInterface $messenger) {
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[ConfigEvents::SAVE][] = ['configSave', -100];
    $events[ConfigEvents::DELETE][] = ['configDelete', 100];
    return $events;
  }

  /**
   * Config save event callback.
   *
   * @param \Drupal\Core\Config\ConfigCrudEvent $event
   *   The config save event.
   */
  public function configSave(ConfigCrudEvent $event) {
    $config = $event->getConfig();
    $this->messenger->addMessage('Saved config: ' . $config->getName());
  }

  /**
   * Config delete event callback.
   *
   * @param \Drupal\Core\Config\ConfigCrudEvent $event
   *   The config delete event.
   */
  public function configDelete(ConfigCrudEvent $event) {
    $config = $event->getConfig();
    $this->messenger->addMessage('Deleted config: ' . $config->getName());
  }

}