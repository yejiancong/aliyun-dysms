<?php

namespace yejiancong\AliyunSms;

use Aliyun\Api\Sms\Request\V20170525\QuerySendDetailsRequest;
use Aliyun\Api\Sms\Request\V20170525\SendBatchSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Core\Config;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Core\Profile\DefaultProfile;

// 加载区域结点配置
Config::load();


/**
 * Class AliyunSms
 *
 * @package yejiancong\AliyunSms
 */
class AliyunSms
{


    /**
     * @var string
     */
    protected static $accessKeyId;


    /**
     * @var string
     */
    protected static $accessKeySecret;


    /**
     * @var string
     */
    protected static $SignName;


    /**
     * @var DefaultAcsClient
     */
    protected static $acsClient;


    /**
     * @param string $accessKeyId
     */
    public static function setAccessKeyId($accessKeyId)
    {
        self::$accessKeyId = $accessKeyId;
    }

    /**
     * @param string $accessKeySecret
     */
    public static function setAccessKeySecret($accessKeySecret)
    {
        self::$accessKeySecret = $accessKeySecret;
    }

    /**
     * @param string $SignName
     */
    public static function setSignName($SignName)
    {
        self::$SignName = $SignName;
    }


    /**
     * @return string
     */
    public static function getAccessKeyId()
    {
        return self::$accessKeyId;
    }


    /**
     * @return string
     */
    public static function getAccessKeySecret()
    {
        return self::$accessKeySecret;
    }


    /**
     * @return string
     */
    public static function getSignName()
    {
        return self::$SignName;
    }

    /**
     * 取得AcsClient
     *
     * @return DefaultAcsClient
     */
    public static function getAcsClient()
    {
        //产品名称:云通信流量服务API产品,开发者无需替换
        $product = 'Dysmsapi';

        //产品域名,开发者无需替换
        $domain = 'dysmsapi.aliyuncs.com';

        // TODO 此处需要替换成开发者自己的AK (https://ak-console.aliyun.com/)
        $accessKeyId = self::$accessKeyId;

        $accessKeySecret = self::$accessKeySecret;

        // 暂时不支持多Region
        $region = 'cn-hangzhou';

        // 服务结点
        $endPointName = 'cn-hangzhou';


        if (static::$acsClient === null) {

            //初始化acsClient,暂不支持region化
            $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);

            // 增加服务结点
            DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);

            // 初始化AcsClient用于发起请求
            static::$acsClient = new DefaultAcsClient($profile);
        }
        return static::$acsClient;
    }

    /**
     * 发送短信
     *
     * @param string $PhoneNumbers
     * @param string $TemplateCode
     * @param array  $TemplateParam
     * @param string $OutId
     * @param string $SmsUpExtendCode
     *
     * @return mixed|\SimpleXMLElement
     */
    public static function sendSms($PhoneNumbers,
                                   $TemplateCode,
                                   array $TemplateParam,
                                   $OutId = '$OutId',
                                   $SmsUpExtendCode = '1234567')
    {

        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendSmsRequest();

        // 必填，设置短信接收号码
        $request->setPhoneNumbers($PhoneNumbers);

        // 必填，设置签名名称，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $request->setSignName(static::$SignName);

        // 必填，设置模板CODE，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $request->setTemplateCode($TemplateCode);

        // 可选，设置模板参数, 假如模板中存在变量需要替换则为必填项
        $request->setTemplateParam(json_encode($TemplateParam, JSON_UNESCAPED_UNICODE));

        // 可选，设置流水号
        $request->setOutId($OutId);

        // 选填，上行短信扩展码（扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段）
        $request->setSmsUpExtendCode($SmsUpExtendCode);

        // 发起访问请求
        return static::getAcsClient()->getAcsResponse($request);
    }

    /**
     * 批量发送短信
     *
     * @param array  $PhoneNumbers
     * @param array  $SignNames
     * @param string $TemplateCode
     * @param array  $TemplateParams
     *
     * @return mixed|\SimpleXMLElement
     */
    public
    static function sendBatchSms(array $PhoneNumbers, array $SignNames, $TemplateCode, array $TemplateParams)
    {

        // 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendBatchSmsRequest();

        // 必填:待发送手机号。支持JSON格式的批量调用，批量上限为100个手机号码,批量调用相对于单条调用及时性稍有延迟,验证码类型的短信推荐使用单条调用的方式
        $request->setPhoneNumberJson(json_encode($PhoneNumbers, JSON_UNESCAPED_UNICODE));

        // 必填:短信签名-支持不同的号码发送不同的短信签名
        $request->setSignNameJson(json_encode($SignNames, JSON_UNESCAPED_UNICODE));

        // 必填:短信模板-可在短信控制台中找到
        $request->setTemplateCode($TemplateCode);

        // 必填:模板中的变量替换JSON串,如模板内容为"亲爱的${name},您的验证码为${code}"时,此处的值为
        // 友情提示:如果JSON中需要带换行符,请参照标准的JSON协议对换行符的要求,比如短信内容中包含\r\n的情况在JSON中需要表示成\\r\\n,否则会导致JSON在服务端解析失败
        $request->setTemplateParamJson(json_encode($TemplateParams, JSON_UNESCAPED_UNICODE));

        // 可选-上行短信扩展码(扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段)
        // $request->setSmsUpExtendCodeJson("[\"90997\",\"90998\"]");

        // 发起访问请求
        return static::getAcsClient()->getAcsResponse($request);
    }

    /**
     * 短信发送记录查询
     *
     * @param string $PhoneNumber
     * @param string $SendDate
     * @param string $BizId
     *
     * @return mixed|\SimpleXMLElement
     */
    public
    static function querySendDetails($PhoneNumber, $SendDate, $BizId = 'yourBizId')
    {
        // 初始化QuerySendDetailsRequest实例用于设置短信查询的参数
        $request = new QuerySendDetailsRequest();

        // 必填，短信接收号码
        $request->setPhoneNumber($PhoneNumber);

        // 必填，短信发送日期，格式Ymd，支持近30天记录查询
        $request->setSendDate($SendDate);

        // 必填，分页大小
        $request->setPageSize(10);

        // 必填，当前页码
        $request->setCurrentPage(1);

        // 选填，短信发送流水号
        $request->setBizId($BizId);

        // 发起访问请求
        return static::getAcsClient()->getAcsResponse($request);
    }


    /**
     * @param $acsResponse
     *
     * @return bool
     */
    public static function ok($acsResponse)
    {
        return isset($acsResponse->Message) && $acsResponse->Message === 'OK';
    }

}
