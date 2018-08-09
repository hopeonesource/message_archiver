<?php

namespace Drupal\message_archiver\util;


class Util {
  public static function getDate($unixtimestamp){
    $datetimeFormat = 'Y-m-d H:i:s';
    $date = new \DateTime();
    $date->setTimestamp($unixtimestamp);
    return $date->format($datetimeFormat);
  }
  public static function processResult($results){
    $output = array();
    foreach ($results as $result) {
      $output[$result->id] = [
        'session_id' => $result->sms_provider_session_id,
        'msg_text' => $result->message_text,
        'time_queued' => Util::getDate($result->timestamp_when_queued),
        'time_sent' => Util::getDate($result->timestamp_when_sent),
        'phone_number' => $result->phone_number,
        'uid' => $result->uid,
        'nid' => $result->nid
      ];
    }
    return $output;
  }
}