<?php

namespace yejiancong\AliyunSms;

/**
 * Class ServiceProvider
 *
 * @package yejiancong\AliyunSms
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {

        if (config('aliyun-dysms.dysms.key')) {
            AliyunSms::setAccessKeyId(config('aliyun-dysms.dysms.key'));
        }

        if (config('aliyun-dysms.dysms.secret')) {
            AliyunSms::setAccessKeySecret(config('aliyun-dysms.dysms.secret'));
        }

        if (config('aliyun-dysms.dysms.sign')) {
            AliyunSms::setSignName(config('aliyun-dysms.dysms.sign'));
        }

        $this->publishes([
                             __DIR__ . '/../config/aliyun-dysms.php' => config_path('aliyun-dysms.php'),
                         ]);
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('AliyunSms', function () {
            return new AliyunSms();
        });

        $this->app->alias('AliyunSms', Facade::class);
    }
}
