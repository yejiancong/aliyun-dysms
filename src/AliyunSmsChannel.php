<?php

namespace Songshenzong\AliyunSms;

use Illuminate\Notifications\Notification;

/**
 * Class AliyunSmsChannel
 *
 * @package Songshenzong\AliyunSms
 */
class AliyunSmsChannel
{
    /**
     * @param              $notifiable
     * @param Notification $notification
     *
     * @return mixed
     */
    public function send($notifiable, Notification $notification)
    {
        return $notification->toAliyunSMS($notifiable);
    }
}
