<?php

/**
 * @file
 * Provide views data for message_archiver.module.
 */

/**
 * Implements hook_views_data().
 */
function message_archiver_views_data() {
  $data = [];
  $data['message_archives'] = [];
  $data['message_archives']['table'] = [];
  $data['message_archives']['table']['group'] = t('Message');

  $data['message_archives']['table']['base'] = [
    'field' => 'id',
    'title' => t('Messages'),
    'help' => t('Messages that have been archived on this site.'),
  ];

  $data['message_archives']['id'] = [
    'title' => t('ID'),
    'field' => [
      'id' => 'field',
      'click sortable' => TRUE,
    ],
  ];

  $data['message_archives']['uid'] = [
    'title' => t('User id'),
    'help' => t('Relate message to the user who created it.'),
    'field' => [
      'id' => 'standard',
    ],
    'relationship' => [
      'base' => 'users_field_data',
      'base field' => 'uid',
      'id' => 'standard',
      'label' => t('user'),
    ],
  ];

  $data['message_archives']['nid'] = [
    'title' => t('Node id'),
    'help' => t('Relate message to the content it was created on.'),
    'field' => [
      'id' => 'standard',
    ],
    'relationship' => [
      'base' => 'node_field_data',
      'base field' => 'nid',
      'id' => 'standard',
      'label' => t('node'),
    ],
  ];

  $data['message_archives']['message_text'] = [
    'title' => t('Text'),
    'help' => t('The text content of the message.'),
    'field' => [
      'id' => 'standard',
    ],
    'sort' => [
      'id' => 'standard',
    ],
    'filter' => [
      'id' => 'string',
    ],
    'argument' => [
      'id' => 'string',
    ],

  ];

  $data['message_archives']['timestamp_when_queued'] = [
    'title' => t('Queued'),
    'help' => t('Timestamp when the message was queued.'),
    'field' => [
      'id' => 'date',
    ],
    'sort' => [
      'id' => 'date',
    ],
    'filter' => [
      'id' => 'date',
    ],
  ];

  $data['message_archives']['timestamp_when_sent'] = [
    'title' => t('Sent'),
    'help' => t('Timestamp when the message was sent.'),
    'field' => [
      'id' => 'date',
    ],
    'sort' => [
      'id' => 'date',
    ],
    'filter' => [
      'id' => 'date',
    ],
  ];

  $data['message_archives']['phone_number'] = [
    'title' => t('Phone number'),
    'help' => t('The telephone number from which the message was sent.'),
    'field' => [
      'id' => 'numeric',
    ],
    'sort' => [
      'id' => 'standard',
    ],
    'filter' => [
      'id' => 'numeric',
    ],
    'argument' => [
      'id' => 'numeric',
    ],
  ];

  $data['message_archives']['sms_provider_session_id'] = [
    'title' => t('Session ID'),
    'help' => t('The session id for the SMS provider.'),
    'field' => [
      'id' => 'standard',
    ],
    'sort' => [
      'id' => 'standard',
    ],
    'filter' => [
      'id' => 'string',
    ],
    'argument' => [
      'id' => 'string',
    ],
  ];

  return $data;
}
