<?php

namespace yejiancong\AliyunSms;

/**
 * Class Facade
 *
 * @package yejiancong\AliyunSms
 */
class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'AliyunSms';
    }
}
