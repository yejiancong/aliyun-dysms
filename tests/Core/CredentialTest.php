<?php

namespace Songshenzong\AliyunSms\Test;

use PHPUnit\Framework\TestCase;
use Songshenzong\AliyunSms\AliyunSms;
use function getenv;

/**
 * Class CredentialTest
 *
 * @package Songshenzong\AliyunSms\Test
 */
class CredentialTest extends TestCase
{
    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testCredential()
    {
        AliyunSms::setAccessKeyId(getenv('ALIYUN_DYSMS_KEY'));
        AliyunSms::setAccessKeySecret(getenv('ALIYUN_DYSMS_SECRET'));
        AliyunSms::setSignName(getenv('ALIYUN_DYSMS_SIGN'));
        $this->assertEquals(getenv('ALIYUN_DYSMS_KEY'), AliyunSms::getAccessKeyId());
        $this->assertEquals(getenv('ALIYUN_DYSMS_SECRET'), AliyunSms::getAccessKeySecret());
        $this->assertEquals(getenv('ALIYUN_DYSMS_SIGN'), AliyunSms::getSignName());
    }


    /**
     * @depends testCredential
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testSend()
    {
        if (getenv('ALIYUN_DYSMS_SECRET')) {
            $response = AliyunSms::sendSms(getenv('PHONE'),
                                           getenv('TEMPLATE_CODE'),
                                           ['code' => '12345']);
            $this->assertObjectHasAttribute('Message', $response);
        } else {
            $this->assertEquals(true, true);
        }

    }
}
