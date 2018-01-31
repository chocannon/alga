<?php
// +----------------------------------------------------------------------
// | 常用字符串处理函数
// +----------------------------------------------------------------------
// | Author: chocannon@outlook.com
// +----------------------------------------------------------------------

namespace Alga;

class Str
{
    private static $cache = [];


    /**
     * 检测字符串是否包含某些字符
     * @param  string       $haystack 
     * @param  array|string $needles  
     * @return bool
     */
    public static function contains($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if (!empty($needle) && false !== mb_strpos($haystack, $needle)) {
                return true;
            }
        }
        return false;
    }


    /**
     * 截取字符串
     * @param  string   $string 
     * @param  int      $start  
     * @param  int|null $length 
     * @return string
     */
    public static function substr($string, $start, $length = null)
    {
        return mb_substr($string, $start, $length, 'UTF-8');
    }


    /**
     * 获取字符串长度
     * @param  string $string 
     * @return int 
     */
    public static function strlen($string)
    {
        return mb_strlen($string);
    }


    /**
     * 检测字符串是否以某些字符结尾
     * @param  string       $haystack 
     * @param  string|array $needles 
     * @return bool         
     */
    public static function endWith($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ($needle === self::substr($haystack, -self::strlen($needle))) {
                return true;
            }
        }
        return false;
    }


    /**
     * 检测字符串是否以某些字符开头
     * @param  string       $haystack 
     * @param  string|array $needles 
     * @return bool      
     */
    public static function startWith($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ($needle === self::substr($haystack, 0, self::strlen($needle))) {
                return true;
            }
        }
        return false;
    }


    /**
     * 字符串转小写
     * @param  string $string
     * @return string 
     */
    public static function lower($string)
    {
        return mb_strtolower($string, 'UTF-8');
    }


    /**
     * 字符串转大写
     * @param  string $string
     * @return string 
     */
    public static function upper($string)
    {
        return mb_strtoupper($string);
    }


    /**
     * 驼峰转蛇形
     * @param  string $string    
     * @param  string $delimiter 
     * @return string 
     */
    public static function snake($string, $delimiter = '_')
    {
        $key = $string;
        if (isset(self::$cache['snake'][$key][$delimiter])) {
            return self::$cache['snake'][$key][$delimiter];
        }

        if (!ctype_lower($string)) {
            $string = preg_replace('/\s+/u', '', $string);
            $string = self::lower(preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $string));
        }

        return self::$cache['snake'][$key][$delimiter] = $string;
    }


    /**
     * 蛇形转驼峰
     * @param  string  $string
     * @param  boolean $lcf 
     * @return string  
     */
    public static function camel($string, $lcf = true)
    {
        $key = $string;
        if (isset(self::$cache['camel'][$key][(int)$lcf])) {
            return self::$cache['camel'][$key][(int)$lcf];
        }

        $string = str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $string)));
        if (true === $lcf) {
            $string = lcfirst($string);
        }
        return self::$cache['camel'][$key][(int)$lcf] = $string;
    }
}