<?php

namespace Songshenzong\AliyunSms;

/**
 * Class Facade
 *
 * @package Songshenzong\AliyunSms
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
