<?php
/**
 * Created by PhpStorm.
 * User: 隆航
 * Date: 2016/12/26 0026
 * Time: 16:47
 */

/**
 * RSA 签名
 * @param $data
 * @param $private_key
 * @return string
 */
function rsaSign($data, $private_key) {
    //以下为了初始化私钥，保证在您填写私钥时不管是带格式还是不带格式都可以通过验证。
    $private_key=str_replace("-----BEGIN RSA PRIVATE KEY-----","",$private_key);
    $private_key=str_replace("-----END RSA PRIVATE KEY-----","",$private_key);
    $private_key=str_replace("\n","",$private_key);
    $private_key="-----BEGIN RSA PRIVATE KEY-----".PHP_EOL .wordwrap($private_key, 64, "\n", true). PHP_EOL."-----END RSA PRIVATE KEY-----";
    $res=openssl_get_privatekey($private_key);
    if($res)
    {
        openssl_sign($data, $sign,$res);
    }
    else {
        echo "您的私钥格式不正确!"."<br/>"."The format of your private_key is incorrect!";
        exit();
    }
    openssl_free_key($res);
    //base64编码
    $sign = base64_encode($sign);
    return $sign;
}

/**
 * RSA 验签
 * @param $data
 * @param $sign
 * @param $public_key
 * @return bool
 */
function rsaVerify($data,$sign,$public_key)
{
    //以下为了初始化私钥，保证在您填写私钥时不管是带格式还是不带格式都可以通过验证。
    $public_key=str_replace("-----BEGIN PUBLIC KEY-----","",$public_key);
    $public_key=str_replace("-----END PUBLIC KEY-----","",$public_key);
    $public_key=str_replace("\n","",$public_key);

    $public_key='-----BEGIN PUBLIC KEY-----'.PHP_EOL.wordwrap($public_key, 64, "\n", true) .PHP_EOL.'-----END PUBLIC KEY-----';
    $res=openssl_get_publickey($public_key);
    if($res)
    {
        $result = (bool)openssl_verify($data, base64_decode($sign), $res);
    }
    else {
        echo "您的支付宝公钥格式不正确!"."<br/>"."The format of your alipay_public_key is incorrect!";
        exit();
    }
    openssl_free_key($res);
    return $result;
}