<?php

namespace Songshenzong\AliyunSms;

use Illuminate\Notifications\Notification;

/**
 * Class AliyunBatchSmsChannel
 *
 * @package Songshenzong\AliyunSms
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
