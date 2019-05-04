<?php

namespace yejiancong\AliyunSms;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * Class AliyunSendBatchSmsJob
 *
 * @package yejiancong\AliyunSms
 */
class AliyunSendBatchSmsJob implements ShouldQueue
{
    use Queueable, Dispatchable;

    /**
     * @var array
     */
    public $func_get_args;


    /**
     * AliyunSendBatchSmsJob constructor.
     *
     * @param array  $PhoneNumbers
     * @param array  $SignNames
     * @param string $TemplateCode
     * @param array  $TemplateParams
     */
    public function __construct(array $PhoneNumbers, array $SignNames, $TemplateCode, array $TemplateParams)
    {
        $this->func_get_args = func_get_args();
    }


    /**
     * Handle
     */
    public function handle()
    {
        AliyunSms::sendBatchSms(...$this->func_get_args);
    }
}
