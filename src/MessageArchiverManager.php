<?php

namespace Drupal\message_archiver;
use Drupal\Core\Database\Driver\mysql\Connection;

/**
 * Class MessageArchiverManager.
 */
class MessageArchiverManager implements MessageArchiverManagerInterface {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $connection;
  /**
   * Constructs a new MessageArchiverManager object.
   */
  public function __construct(Connection $connection) {
    $this->connection = $connection;
  }
  public function archive(array $values){
    $this->connection->insert('message_archives')
      ->fields([
        'id','nid','message_text','timestamp_when_queued','timestamp_when_sent',
        'phone_number', 'sms_provider_session_id'
      ])->values($values)->execute();
  }
  public function getMessageBySessionId($sessionId){
    $query = $this->connection->select('message_archives', 'ma')
      ->fields('ma')->condition('sms_provider_session_id', $sessionId);
    $pager = $query->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(20);
    $results = $pager->execute()->fetchAll();
    return $results;
  }
  public function getMessages(){
    $query = $this->connection->select('message_archives', 'ma');
    $query->fields('ma');
    $pager = $query->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(20);
    $results = $pager->execute()->fetchAll();
    return $results;
  }
}
