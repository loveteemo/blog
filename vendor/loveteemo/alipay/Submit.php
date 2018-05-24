<?php

namespace loveteemo\alipay;

class Submit {

	var $alipay_config;
	/**
	 *支付宝网关地址（新）
	 */
	var $alipay_gateway_new = 'https://mapi.alipay.com/gateway.do?';

	function __construct($alipay_config){
		$this->alipay_config = $alipay_config;
	}
    function AlipaySubmit($alipay_config) {
    	$this->__construct($alipay_config);
    }

    /**
     * PC 生成签名结果
     * @param $para_sort
     * @return string
     */
	function buildRequestMysign($para_sort) {
		//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		$prestr = createLinkstring($para_sort);
		
		$mysign = "";
		switch (strtoupper(trim($this->alipay_config['sign_type']))) {
			case "MD5" :
				$mysign = md5Sign($prestr, $this->alipay_config['key']);
				break;
			default :
				$mysign = "";
		}
		
		return $mysign;
	}

    /**
     * PC 生成请求参数
     * @param $para_temp
     * @return mixed
     */
	function buildRequestPara($para_temp) {
		//除去待签名参数数组中的空值和签名参数 sign_type 参与签名
		$para_filter = appParaFilter($para_temp);

		//对待签名参数数组排序
		$para_sort = argSort($para_filter);
		//生成签名结果
		$mysign = $this->appbuildRequestMysign($para_sort);
		
		//签名结果与签名方式加入请求提交参数组中
		$para_sort['sign'] = $mysign;
		$para_sort['sign_type'] = strtoupper(trim($this->alipay_config['sign_type']));
		return $para_sort;
	}

    /**
     * PC 生成要请求给支付宝的参数数组
     * @param $para_temp
     * @return string
     */
	function buildRequestParaToString($para_temp) {
		//待请求参数数组
		$para = $this->buildRequestPara($para_temp);
		
		//把参数组中所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
		$request_data = createLinkstringUrlencode($para);
		
		return $request_data;
	}

    /**
     * PC 表单请求
     * @param $para_temp
     * @param $method
     * @param $button_name
     * @return string
     */
	function buildRequestForm($para_temp, $method, $button_name) {
		//待请求参数数组
		$para = $this->buildRequestPara($para_temp);
		
		$sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".$this->alipay_gateway_new."_input_charset=".trim(strtolower($this->alipay_config['input_charset']))."' method='".$method."'>";
		while (list ($key, $val) = each ($para)) {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }

		//submit按钮控件请不要含有name属性
        $sHtml = $sHtml."<input type='submit'  value='".$button_name."' style='display:none;'></form>";
		
		$sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";
		
		return $sHtml;
	}
	
	
	/**
     * 用于防钓鱼，调用接口query_timestamp来获取时间戳的处理函数
	 * 注意：该功能PHP5环境及以上支持，因此必须服务器、本地电脑中装有支持DOMDocument、SSL的PHP配置环境。建议本地调试时使用PHP开发软件
     * return 时间戳字符串
	 */
	function query_timestamp() {
		$url = $this->alipay_gateway_new."service=query_timestamp&partner=".trim(strtolower($this->alipay_config['partner']))."&_input_charset=".trim(strtolower($this->alipay_config['input_charset']));
		$encrypt_key = "";		

		$doc = new DOMDocument();
		$doc->load($url);
		$itemEncrypt_key = $doc->getElementsByTagName( "encrypt_key" );
		$encrypt_key = $itemEncrypt_key->item(0)->nodeValue;
		
		return $encrypt_key;
	}

    /**
     * App支付的时候统一下单请求地址
     * @param $params
     * @return string
     */
	function  appDoWithPay($params)
    {
        $params_tmp = array(
            "app_id"        =>  $this->alipay_config['app_id'],     //应用ID
            "method"        =>  "alipay.trade.app.pay",             //接口名称
            "format"        =>  "JSON",                             //仅支持JSON
            "charset"       =>  "utf-8",                            //编码格式
            "sign_type"     =>  "RSA",                              //签名算法
            "timestamp"     =>  date("Y-m-d H:i:s"),                //时间戳
            "version"       =>  "1.0",                              //接口版本
            "notify_url"    =>  $this->alipay_config['notify_url'], //异步通知
            "biz_content"   =>  json_encode($params,JSON_UNESCAPED_UNICODE)                //业务请求参数 转换成JSON 不转移汉字
        );
        $result_str = $this->appBuildRequestParaToString($params_tmp);
        return $result_str;
    }


    /**
     * APP 请求数组
     * @param $para_temp
     * @return mixed
     */
    function appBuildRequestPara($para_temp) {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = paraFilter($para_temp);

        //对待签名参数数组排序
        $para_sort = argSort($para_filter);

        //生成签名结果
        $mysign = $this->appBuildRequestMysign($para_sort);

        //签名结果与签名方式加入请求提交参数组中
        $para_sort['sign'] = $mysign;

        return $para_sort;
    }

    /**
     * APP 签名数组
     * @param $para_sort
     * @return string
     */
    function appBuildRequestMysign($para_sort) {
        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = createLinkstring($para_sort);

        $mysign = "";
        switch (strtoupper(trim($this->alipay_config['sign_type']))) {
            case "RSA" :
                $mysign = rsaSign($prestr, $this->alipay_config['private_key']);
                break;
            default :
                $mysign = "";
        }
        return $mysign;
    }

    /**
     * APP 唤醒参数
     * @param $para_temp
     * @return string
     */
    function appBuildRequestParaToString($para_temp) {

        //待请求参数数组
        $para = $this->buildRequestPara($para_temp);

        //把参数组中所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
        $request_data = createLinkstringUrlencode($para);
        //$request_data = createLinkstring($para);

        return $request_data;
    }




}
?>