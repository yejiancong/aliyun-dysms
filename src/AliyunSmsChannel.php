<?php

namespace yejiancong\AliyunSms;

use Illuminate\Notifications\Notification;

/**
 * Class AliyunSmsChannel
 *
 * @package yejiancong\AliyunSms
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
