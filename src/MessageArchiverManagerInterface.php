<?php

namespace Drupal\message_archiver;

/**
 * Interface MessageArchiverManagerInterface.
 */
interface MessageArchiverManagerInterface {
  public function archive(array $values);
  public function getMessageBySessionId($sessionId);
  public function getMessages();
}
