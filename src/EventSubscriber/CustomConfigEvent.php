<?php

namespace Drupal\shashank_exercise\EventSubscriber;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Redirects user.
 */
class CustomConfigEvent implements EventSubscriberInterface {

  /**
   * Ad.
   */
  public function checkForRedirection(RequestEvent $event) {
    // Check for redirection.
    // Get request and store it in request variable.
    $request = $event->getRequest();
    // Path obtained and stored in path variable.
    $path = $request->getRequestUri();
    if (strpos($path, 'node/add/page') !== FALSE) {
      // Redirect old  urls.
      // When node add page is entered it gets redirected to node 1.
      $new_url = str_replace('node/add/page', 'node/1', $path);
      $new_response = new RedirectResponse($new_url, '301');
      $new_response->send();
    }
    // This is necessary because this also gets called on
    // node sub-tabs such as "edit", "revisions", etc.  This
    // prevents those pages from redirected.
    if ($request->attributes->get('_route') !== 'entity.node.canonical') {
      return;
    }

  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    // The dynamic cache subscribes an event with priority 27.
    // If you want that your code runs before, you have to use a priority >27:
    $events[KernelEvents::REQUEST][] = ['checkForRedirection', 29];
    return $events;
  }

}
