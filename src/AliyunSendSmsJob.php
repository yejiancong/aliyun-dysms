<?php

namespace Songshenzong\AliyunSms;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class AliyunSendSmsJob
 *
 * @package Songshenzong\AliyunSms
 */
class AliyunSendSmsJob implements ShouldQueue
{
    use Queueable, Dispatchable;

    /**
     * @var array
     */
    public $func_get_args;

    /**
     * AliyunSmsJob constructor.
     *
     * @param string $PhoneNumbers
     * @param string $TemplateCode
     * @param array  $TemplateParam
     * @param string $OutId
     * @param string $SmsUpExtendCode
     */
    public function __construct($PhoneNumbers,
                                $TemplateCode,
                                array $TemplateParam,
                                $OutId = '$OutId',
                                $SmsUpExtendCode = '1234567')
    {
        $this->func_get_args = func_get_args();
    }


    /**
     * Handle
     */
    public function handle()
    {
        AliyunSms::sendSms(...$this->func_get_args);
    }
}
