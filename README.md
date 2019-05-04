[![Songshenzong](https://songshenzong.com/images/logo.png)](https://songshenzong.com)

[![Build Status](https://travis-ci.org/songshenzong/aliyun-dysms.svg?branch=master)](https://travis-ci.org/songshenzong/aliyun-dysms)
[![Total Downloads](https://poser.pugx.org/songshenzong/aliyun-dysms/d/total.svg)](https://packagist.org/packages/songshenzong/aliyun-dysms)
[![Latest Stable Version](https://poser.pugx.org/songshenzong/aliyun-dysms/v/stable.svg)](https://packagist.org/packages/songshenzong/aliyun-dysms)
[![License](https://poser.pugx.org/songshenzong/aliyun-dysms/license.svg)](https://packagist.org/packages/songshenzong/aliyun-dysms)
[![PHP Version](https://img.shields.io/packagist/php-v/songshenzong/aliyun-dysms.svg)](https://packagist.org/packages/songshenzong/aliyun-dysms)



## Installation

Require this package with composer:

```shell
composer require songshenzong/aliyun-dysms
```




## Settings
```php
 
 /**
 * If Laravel, Please write these fields in the `env` file
 */
  
 ALIYUN_DYSMS_KEY=yourAccessKeyId
 ALIYUN_DYSMS_SECRET=yourAccessKeySecret
 ALIYUN_DYSMS_SIGN=yourSignName
 
 
 /**
 * If not Laravel, You have to run these methods first.
 */
 
 AliyunSms::setAccessKeyId('yourAccessKeyId');
 AliyunSms::setAccessKeySecret('yourAccessKeySecret');
 AliyunSms::setSignName('yourSignName');
 
```





## Send SMS
```php
 
// Send SMS without `SignName` if used `setSignName`.
$response = AliyunSms::sendSms('18888888888', 'SMS_12345678', ['code' => 12345]);
 
 
// Send in bulk, no more than 1000 phone numbers.
$response = AliyunSms::sendSms('18888888888,17777777777', 'SMS_12345678', ['code' => 12345]);
 
$response = AliyunSms::sendBatchSms(['1500000000', '1500000001'], ['云通信', '云通信'], 'SMS_12345678', [['code' => '123'], ['code' => '456']]);
 
  
// Get Result
if (AliyunSms::ok($response)) {
   echo 'OK';
} else {
   echo 'Failed';
}
 
```


## Laravel Artisan

Publish configuration files. If not, They can not be serialized correctly when you execute the `config:cache` Artisan command.

```shell
php artisan vendor:publish --provider="Songshenzong\AliyunSms\ServiceProvider"
```



## Laravel Queues

```php
 
AliyunSendSmsJob::dispatch('18888888888', "SMS_12345678", ['code' => 520])->onQueue('sms');
  
AliyunSendSmsJob::dispatchNow('18888888888', "SMS_12345678", ['code' => 520]);
 
```





## Laravel Notifications

```php

/**
 * Get the notification's delivery channels.
 *
 * @param   $notifiable
 *
 * @return array
 */
public function via($notifiable): array
{
    return [AliyunBatchSmsChannel::class, AliyunSmsChannel::class];
}
 
 
/**
 * @param $notifiable
 *
 * @return mixed
 */
public function toAliyunSMS($notifiable)
{
    return AliyunSms::sendSms('18888888888', 'SMS_12345678', ['code' => 12345]);
}
 
  
/**
 * @param $notifiable
 *
 * @return mixed
 */
public function toAliyunBatchSMS($notifiable)
{
    return AliyunSms::sendBatchSms(['1500000000', '1500000001'], ['云通信', '云通信'], 'SMS_12345678', [['code' => '123'], ['code' => '456']]);
}
 

```





## More Usage

See: https://help.aliyun.com/document_detail/55359.html



## Documentation

Please refer to our extensive [Wiki documentation](https://github.com/songshenzong/aliyun-dysms/wiki) for more information.


## Support

For answers you may not find in the Wiki, avoid posting issues. Feel free to ask for support on Songshenzong.com


## License

This package is licensed under the [BSD 3-Clause license](http://opensource.org/licenses/BSD-3-Clause).
