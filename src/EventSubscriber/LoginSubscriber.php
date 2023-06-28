<?php

namespace Drupal\shashank_exercise\EventSubscriber;

// To use the custom Event created.
use Drupal\shashank_exercise\Event\UserLoginEvent;
// Used as base class.
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Messenger\MessengerInterface;

/**
 * Class.
 */
class LoginSubscriber implements EventSubscriberInterface {
  // Extending the base class.

  /**
   * The database service.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * UserLoginEvent constructor.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database service.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $dateFormatter
   *   The date formatter service.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   */
  public function __construct(Connection $database, DateFormatterInterface $dateFormatter, MessengerInterface $messenger) {
    $this->database = $database;
    $this->dateFormatter = $dateFormatter;
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      // Static class constant => method on this class.
      UserLoginEvent::EVENT_NAME => 'onUserLogin',
    ];
  }

  /**
   * Subscribe to the user login event dispatched.
   *
   * @param \Drupal\shashank_exercise\Event\UserLoginEvent $event
   *   Our custom general object.
   */
  public function onUserLogin(UserLoginEvent $event) {
    // Selecting the table from db.
    $account_created = $this->database->select('users_field_data', 'ud')
      // Returns when the account was created.
      ->fields('ud', ['created'])
      // Returns the userid.
      ->condition('ud.uid', $event->account->id())
      ->execute()
      ->fetchField();

    // Using message service to get message whenever user logs in.
    $this->messenger->addStatus(t('Welcome to the site, your account was created on %created_date.', [
      '%created_date' => $this->dateFormatter->format($account_created, 'long'),
    ]));
  }

}