<?php

namespace yejiancong\AliyunSms;

use Illuminate\Notifications\Notification;

/**
 * Class AliyunBatchSmsChannel
 *
 * @package yejiancong\AliyunSms
 */
class AliyunBatchSmsChannel
{

    /**
     * @param              $notifiable
     * @param Notification $notification
     *
     * @return mixed
     */
    public function send($notifiable, Notification $notification)
    {
        return $notification->toAliyunBatchSMS($notifiable);
    }
}
