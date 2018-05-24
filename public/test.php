<?php

$encrypt = new encrypt();
$postdata = $_GET['str'];
var_dump($encrypt->decrypt($postdata));
echo json_decode(array("str"=>$encrypt->decrypt($postdata)));



/**
 * 加密解密类
*/

class encrypt
{
    
    private static $_instance = NULL;
    public static $_key = 'fDe16F9c';
    /**
     * @return JoDES
     */
    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new encrypt();
        }
        return self::$_instance;
    }
 
    /**
     * 加密
     * @param string $str 要处理的字符串
     * @param string $key 加密Key，为8个字节长度
     * @return string
     */
    public function encode($str, $key='') {
		!$key && $key = encrypt::$_key;
		
        $size = mcrypt_get_block_size(MCRYPT_DES, MCRYPT_MODE_CBC);
        $str = $this->pkcs5Pad($str, $size);
        $aaa = mcrypt_encrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_CBC, $key);
        $ret = base64_encode($aaa);
        return $ret;
    }
 
    /**
     * 解密
     * @param string $str 要处理的字符串
     * @param string $key 解密Key，为8个字节长度
     * @return string
     */
    public function decrypt($str, $key='') {
		!$key && $key = encrypt::$_key;
		
        $strBin = base64_decode($str);
        $str = mcrypt_decrypt(MCRYPT_DES, $key, $strBin, MCRYPT_MODE_CBC, $key);
        $str = $this->pkcs5Unpad($str);
        return $str;
    }
 
    function hex2bin($hexData) {
        $binData = "";
        for ($i = 0; $i < strlen($hexData); $i += 2) {
            $binData .= chr(hexdec(substr($hexData, $i, 2)));
        }
        return $binData;
    }
 
    function pkcs5Pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }
 
    function pkcs5Unpad($text) {
        $pad = ord($text {strlen($text) - 1});
        if ($pad > strlen($text))
            return false;
 
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad)
            return false;
 
        return substr($text, 0, - 1 * $pad);
    }
   
}
