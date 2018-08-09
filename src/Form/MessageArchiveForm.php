<?php

namespace Drupal\message_archiver\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Path\CurrentPathStack;
use Drupal\message_archiver\MessageArchiverManagerInterface;
use Drupal\message_archiver\util\Util;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class MessageArchiveForm.
 */
class MessageArchiveForm extends FormBase {

  /**
   * @var \Drupal\message_archiver\MessageArchiverManagerInterface
   */
  protected $messageArchiverManager;

  /**
   * @var \Drupal\Core\Path\CurrentPathStack
   */
  protected $currentPath;

  /**
   * MessageArchiveForm constructor.
   *
   * @param \Drupal\message_archiver\MessageArchiverManagerInterface $messageArchiverManager
   * @param \Drupal\Core\Path\CurrentPathStack $currentPath
   */
  public function __construct(MessageArchiverManagerInterface $messageArchiverManager,
                              CurrentPathStack $currentPath) {
    $this->messageArchiverManager = $messageArchiverManager;
    $this->currentPath = $currentPath;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'message_archive_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['msg_search'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t(''),
    );
    $form['msg_search']['sms_provider_session_id'] = array(
      '#type' => 'textfield',
      '#title' => t('User Phone Number'),
     // '#default_value' => isset($form_state['storage']['sms_provider_session_id']) ? $form_state['storage']['sms_provider_session_id'] : '*',
      '#default_value' => '*',
      '#description' => t("Please enter a Tropo session ID if you have it. You will find this in the admin/reports/dblog. Otherwise, enter '*'. Note about status codes below: Look at https://www.tropo.com/docs/webhooks/sms-delivery-report for details but for a shorthand: 0 = Sent, 2 = Delivered, 3 = Expired, 5 = Undelivered, 6 = Accepted, 8 = Rejected"),
      '#required' => TRUE,
    );
    $form['msg_search']['submit'] = array(
      '#type' => 'submit',
      '#value' => 'Search Archives',
    );


    $header = array("session_id" => $this->t('Session id'), "msg_text" => $this->t('Message Text'),
      "time_queued" => $this->t('Time Queued'), "time_sent" => $this->t('Time sent'),
      "phone_number" => $this->t('Phone Number'), "uid" => $this->t('Client id'),
      "nid" => $this->t('Posting Id'));
    $output = array();

    $form['msg_results'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t(''),
    );

    if (isset($_GET['sms_provider_session_id']) ){
      if ($_GET['sms_provider_session_id'] == '*'){
        $results = $this->messageArchiverManager->getMessages();
        $output = Util::processResult($results);
        $form['msg_results']['table'] = [
          '#type' => 'tableselect',
          '#header' => $header,
          '#options' => $output,
          '#empty' => t('No archived messages found.'),
        ];
      }
      else{
        $results = $this->messageArchiverManager->getMessageBySessionId($_GET['sms_provider_session_id']);
        $output = Util::processResult($results);
        $form['msg_results']['table'] = [
          '#type' => 'tableselect',
          '#header' => $header,
          '#options' => $output,
          '#empty' => t('No archived messages found.'),
        ];
      }
    }
    else{
      $results = $this->messageArchiverManager->getMessages();
      $output = Util::processResult($results);

      $form['msg_results']['table'] = [
        '#type' => 'tableselect',
        '#header' => $header,
        '#options' => $output,
        '#empty' => t('No archived messages found.'),
      ];
    }

    $form['msg_results']['pager'] = array(
      '#type' => 'pager'
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $args = array(
      'sms_provider_session_id' => $form_state->getValue('sms_provider_session_id')
    );
    $form_state->setRedirect('message_archiver.message_archive_form', $args);
  }
  public static function create(ContainerInterface $container ){
    return new static(
      $container->get('message_archiver.manager'),
      $container->get('path.current')
    );
  }
  /*private function processResult($results){
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
  }*/
}
