<?php
/**
 * 自定义助手
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/9
 * Time: 15:26
 */


if(!function_exists('cnMobileValidate')){
	/**
	 * 中国手机号码验证
	 * @param string $mobile    手机号码
	 * @return bool
	 */
	function cnMobileValidate($mobile){
		return preg_match('/^(13[0-9]|14[5,7]|15[0,1,2,5,6,7,8,9]|16[6]|17[0,6,7,8,9]|18[0-9]|19[9])\d{8}$/',$mobile) ? true : false;
	}
}

if(!function_exists('simpleMobileValidate')){
    /**
     * 简单手机号码检测，5-11位
     * @param string $mobile    手机号码
     * @return bool
     */
    function simpleMobileValidate($mobile){
        return preg_match('/^\d{5,11}$/',$mobile) ? true : false;
    }
}

if(!function_exists('countryCodeValidate')){
    /**
     * 国家区号简单检测
     * @param string $countryCode 国家区号（一般为数字或者中横杠）
     * @return bool
     */
    function countryCodeValidate($countryCode){
        return preg_match('/^[\d-]{1,5}$/',$countryCode) ? true : false;
    }
}

if(!function_exists('imgUrl')){
    /**
     * 图片绝对地址
     * @param string $url   原始地址
     * @return string
     */
	function imgUrl($url){
        return $url ? config('mbnb.IMG_DOMAIN').$url : '';
	}
}


if(!function_exists('getRealIp')){
    /**
     * 获取真实IP
     * @return string
     */
    function getRealIp() {
        $proxy_headers = array(
            'CLIENT_IP',
            'FORWARDED',
            'FORWARDED_FOR',
            'FORWARDED_FOR_IP',
            'HTTP_CLIENT_IP',
            'HTTP_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED_FOR_IP',
            'HTTP_PC_REMOTE_ADDR',
            'HTTP_PROXY_CONNECTION',
            'HTTP_VIA',
            'HTTP_X_FORWARDED',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED_FOR_IP',
            'HTTP_X_IMFORWARDS',
            'HTTP_XROXY_CONNECTION',
            'VIA',
            'X_FORWARDED',
            'X_FORWARDED_FOR'
        );

        foreach($proxy_headers as $proxy_header)
        {
            if(isset($_SERVER[$proxy_header]) && preg_match("/^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}$/", $_SERVER[$proxy_header])) /* HEADER ist gesetzt und dies ist eine gültige IP */
            {
                return $_SERVER[$proxy_header];
            }
            else if(isset($_SERVER[$proxy_header]) && stristr(',', $_SERVER[$proxy_header]) !== FALSE) /* Behandle mehrere IPs in einer Anfrage(z.B.: X-Forwarded-For: client1, proxy1, proxy2) */
            {
                $proxy_header_temp = trim(array_shift(explode(',', $_SERVER[$proxy_header]))); /* Teile in einzelne IPs, gib die letzte zurück und entferne Leerzeichen */

                if(($pos_temp = stripos($proxy_header_temp, ':')) !== FALSE) $proxy_header_temp = substr($proxy_header_temp, 0, $pos_temp); /* Entferne den Port */

                if(preg_match("/^([1-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])(\.([0-9]|[1-9][0-9]|1[0-9][0-9]|2[0-4][0-9]|25[0-5])){3}$/", $proxy_header_temp)) return $proxy_header_temp;
            }
        }

        return $_SERVER['REMOTE_ADDR'];
    }
}

if(!function_exists('strCut')){
    /**
     * 截取字符串
     * @param string $str 要截取的字符串
     * @param int $len 长度
     * @param bool $strip_tags 是否清除标签
     * @return string
     */
    function strCut($str, $len=30, $strip_tags=TRUE){
        if($strip_tags)//如果要清除标签。
            $str = strip_tags($str);
        $more = mb_strlen($str,'utf8')<=$len ? '' :'...';
        return mb_substr($str,0,$len,'utf8').$more;
    }
}

if(!function_exists('curlPost')){
    /**
     * 使用POST方式获取数据
     * @param string $url 提交地址
     * @param array $data 提交的post数据
     * @return mixed
     */
    function curlPost($url,$data){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
        curl_setopt($ch,CURLOPT_TIMEOUT,20);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        $return = curl_exec($ch);
        curl_close($ch);
        return $return;
    }
}

if(!function_exists('curlPostJson')){
    /**
     * 使用POST方式获取数据
     * @param string $url 提交地址
     * @param array $data 提交的post数据
     * @return mixed
     */
    function curlPostJson($url,$data){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
        curl_setopt($ch,CURLOPT_TIMEOUT,20);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));
        $return = curl_exec($ch);
        curl_close($ch);
        return $return;
    }
}




if(!function_exists('curlGet')){
    /**
     * CURL使用GET方式获取数据
     * @param string $url 提交地址
     * @return mixed
     */
    function curlGet($url){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
        curl_setopt($ch,CURLOPT_TIMEOUT,20);
        $return = curl_exec($ch);
        curl_close($ch);
        return $return;
    }
}

if(!function_exists('strValidate')){
    /**
     * 检测字符串是否只是中文、字母、空格
     * @param string $str
     * @return bool
     */
    function strValidate($str){
        return preg_match('/^[a-zA-Z\x{4e00}-\x{9fa5}\s]+$/u',$str) == 0 ? false : true;
    }
}

if(!function_exists('strNumValidate')){
    /**
     * 检测字符串是否只是中文、字母、数字
     * @param string $str
     * @return bool
     */
    function strNumValidate($str){
        return preg_match('/^[a-zA-Z0-9\x{4e00}-\x{9fa5}]+$/u',$str) == 0 ? false : true;
    }
}

if(!function_exists('numValidate')){
    /**
     * 检测字符串是否只是数字
     * @param string $str
     * @return bool
     */
    function numValidate($str){
        return preg_match('/^[0-9]+$/',$str) == 0 ? false : true;
    }
}



if(!function_exists('bankCardValidate')){
    /**
     * 银行卡号检测
     * @param string $str
     * @return bool
     */
    function bankCardValidate($str){
        return preg_match('/^(998801|998802|622525|622526|435744|435745|483536|528020|526855|622156|622155|356869|531659|622157|627066|627067|627068|627069)\d{10}$/',$str) == 0 ? false : true;
    }
}

if(!function_exists('emailValidate')){
    /**
     * 邮箱地址有效检测
     * @param string $email 邮箱地址
     * @return bool
     */
     function emailValidate($email){
        return preg_match('/^(\w)+(\.-\w+)*@(\w)+((\.\w{2,3}){1,3})$/i',$email) == 0 ? false : true;
    }
}

if(!function_exists('strPwdValidate')){
    /**
     * 密码需要设置为6到20位的数字、字母、特殊字符的组合
     * @param $password
     * @return bool
     */
    function strPwdValidate($password){
        return preg_match('/^(?=.*?[A-Za-z])(?=.*?[0-9])[a-zA-Z0-9_\-@&=\!#\$%\^\*\(\)+=\|\?<>~`]{6,20}$/',$password) == 0 ? false : true;
    }
}

if(!function_exists('dateValidate')){
    /**
     * 检测日期格式是否有效
     * @param string $date  日期字符
     * @return bool
     */
    function dateValidate($date)
    {
        //匹配日期格式
        if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts))
        {
            //检测是否为日期
            if(checkdate($parts[2],$parts[3],$parts[1]))
                return true;
            else
                return false;
        }
        else
            return false;
    }
}

if(!function_exists('timeValidate')){
    /**
     * 标准时间检测（时分）
     * @param $time
     * @return bool
     */
    function timeValidate($time){
        return preg_match('/^((1|0?)[0-9]|2[0-3]):([0-5][0-9])$/',$time) == 0 ? false : true;
    }
};

if(!function_exists('randomStr')){
    /**
     * 随机字符串（32位以内）
     * @param int $len
     * @return string
     */
    function randomStr($len=6){
        return substr(md5(uniqid()),mt_rand(0,32-$len),$len);
    }
}


if(!function_exists('randomNum')){
    /**
     * 随机数字串
     * @param int $len  长度
     * @return string
     */
    function randomNum($len=5){
        $str = '1234567890';
        $return = '';
        while(strlen($return) < $len){
            $return .= substr($str,mt_rand(0,strlen($str)-1),1);
        }
        return $return;
    }
}

if(!function_exists('orderSn')){
    /**
     * 订单号生成
     * @return string
     */
    function orderSn(){
        return substr(date('Ymd'),1).randomNum(2).date('Hi').randomNum(3);
    }
}

if(!function_exists('orderSnValidate')){
    /**
     * 订单号验证
     * @param string $orderSn   订单号
     * @return bool
     */
    function orderSnValidate($orderSn){
        return preg_match('/^\d{16}$/',$orderSn) == 0 ? false : true;
    }

}

if(!function_exists('idValidate')){

    /**
     * 身份证验证
     * @param string $id            身份证号码
     * @param int $checkGender      检测号码的性别（1为男，2为女，0不检测）
     * @return bool
     */
    function idValidate($id,$checkGender=0){
        $num = strtolower($id);
        if(preg_match('/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|x)$)/',$num) == 0)
            return false;
        if(is_numeric($num)){//全部数字
            if(strlen($num) == 15 ){
                // 省市县（6位）
                $areaNum = substr($num,0,6);
                // 出生年月（6位）
                $dateNum = substr($num,6,6);
                // 性别（3位）
                $sexNum = substr($num,12,3);
            }else{
                // 如果是18位身份证号
                // 省市县（6位）
                $areaNum = substr($num,0,6);
                // 出生年月（8位）
                $dateNum = substr($num,6,8);
                // 性别（3位）
                $sexNum = substr($num,14,3);
                // 校验码（1位）
                $endNum = substr($num,17,1);
            }
        }else{
            // 不是数值
            if(strlen($num) == 15){
                return false;
            }else{
                // 验证前17位为数值，且18位为字符x
                $check17 = substr($num,0,17);
                if(!is_numeric($check17)){
                    return false;
                }
                // 省市县（6位）
                $areaNum = substr($num,0,6);
                // 出生年月（8位）
                $dateNum = substr($num,6,8);
                // 性别（3位）
                $sexNum = substr($num,14,3);
                // 校验码（1位）
                $endNum = substr($num,17,1);
                if($endNum != 'x'){//前面已经转化成为小写，不用检查大写X
                    return false;
                }
            }
        }

        if(!idCheckArea($areaNum)){
            return false;
        }

        if(!idCheckDate($dateNum)){
            return false;
        }

        // 性别1为男，2为女
        if($checkGender == 1){
            if(isset($sexNum)){
                if(!idCheckSex($sexNum)){
                    return false;
                }
            }
        }else if($checkGender == 2){
            if(isset($sexNum)){
                if(idCheckSex($sexNum)){
                    return false;
                }
            }
        }

        if(isset($endNum)){
            if(!idCheckEnd($num)){
                return false;
            }
        }

        return true;
    }
}

if(!function_exists('idCheckArea')){
    // 验证城市
    function idCheckArea($area){
        $num1 = substr($area,0,2);
        $num2 = substr($area,2,2);
        $num3 = substr($area,4,2);
        // 根据GB/T2260—999，省市代码11到65
        if(10 < $num1 && $num1 < 66){
            return true;
        }else{
            return false;
        }
        //============
        // 对市 区进行验证
        //============
    }
}

if(!function_exists('idCheckDate')){
    // 验证出生日期
    function idCheckDate($date){
        if(strlen($date) == 6){
            $date1 = substr($date,0,2);
            $date2 = substr($date,2,2);
            $date3 = substr($date,4,2);
            $statusY = idCheckY('19'.$date1);
        }else{
            $date1 = substr($date,0,4);
            $date2 = substr($date,4,2);
            $date3 = substr($date,6,2);
            $nowY = date("Y",time());
            if(1900 < $date1 && $date1 <= $nowY){
                $statusY = idCheckY($date1);
            }else{
                return false;
            }
        }
        if(0<$date2 && $date2 <13){
            if($date2 == 2){
                // 润年
                if($statusY){
                    if(0 < $date3 && $date3 <= 29){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    // 平年
                    if(0 < $date3 && $date3 <= 28){
                        return true;
                    }else{
                        return false;
                    }
                }
            }else{
                $maxDateNum = idGetDateNum($date2);
                if(0<$date3 && $date3 <=$maxDateNum){
                    return true;
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
    }
}



if(!function_exists('idCheckY')){
    // 验证平年润年，参数年份,返回 true为润年  false为平年
    function idCheckY($Y){
        if(getType($Y) == 'string'){
            $Y = (int)$Y;
        }
        if($Y % 100 == 0){
            if($Y % 400 == 0){
                return true;
            }else{
                return false;
            }
        }else if($Y % 4 ==  0){
            return true;
        }else{
            return false;
        }
    }
}

if(!function_exists('idGetDateNum')){
    // 当月天数 参数月份（不包括2月）  返回天数
    function idGetDateNum($month){
        if($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12){
            return 31;
        }else if($month == 2){
        }else{
            return 30;
        }
    }
}

if(!function_exists('idCheckSex')){
    // 验证性别
    function idCheckSex($sex){
        if($sex % 2 == 0){
            return false;
        }else{
            return true;
        }
    }
}

if(!function_exists('idCheckEnd')){
    // 验证18位身份证最后一位
    function idCheckEnd($num){
        $checkHou = array(1,0,'x',9,8,7,6,5,4,3,2);
        $checkGu = array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
        $sum = 0;
        for($i = 0;$i < 17; $i++){
            $sum += (int)$checkGu[$i] * (int)$num[$i];
        }
        $checkHouParameter= $sum % 11;
        if($checkHou[$checkHouParameter] != $num[17]){
            return false;
        }else{
            return true;
        }
    }
}

if(!function_exists('simpleCredentialsValidate')){
    /**
     * 简单证件号码验证
     * @param string $number  护照号码
     * @return bool
     */
    function simpleCredentialsValidate($number){
        return preg_match('/(^[a-zA-Z]{5,20}$)|(^[a-zA-Z0-9]{5,17}$)/',$number) == 0 ? false : true;
    }
}

if(!function_exists('passportValidate')){
    /**
     * 护照验证
     * @param string $passport  护照号码
     * @return bool
     */
    function passportValidate($passport){
        return preg_match('/(^[a-zA-Z]{5,17}$)|(^[a-zA-Z0-9]{5,17}$)/',$passport) == 0 ? false : true;
    }
}

if(!function_exists('createUuid')){
    /**
     * 创建UUID
     * @param string $prefix
     * @return string
     */
    function create_uuid($prefix = ""){
        $str = md5(uniqid(mt_rand(), true));
        $uuid  = substr($str,0,8) . '-';
        $uuid .= substr($str,8,4) . '-';
        $uuid .= substr($str,12,4) . '-';
        $uuid .= substr($str,16,4) . '-';
        $uuid .= substr($str,20,12);
        return $prefix . $uuid;
    }
}


