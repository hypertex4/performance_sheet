<?php
$filepath = realpath(dirname(__FILE__));

if(!function_exists('url_path')){
    function url_path($url, $setProtocol = true){
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $protocol = $setProtocol? $protocol:"";
        return $protocol . $_SERVER['HTTP_HOST'] .'/'. 'performance_sheet' . $url;
    }
}

if(!function_exists('asset_path')){
    function asset_path($src){
        return __DIR__.'/../../assets/'.$src;
    }
}

if(!function_exists('public_path')){
    function public_path($src){
        return  url_path('/public/').$src;
    }
}
if(!function_exists('upload_path')){
    function upload_path($src){
        return __DIR__ .'/../../public/'.$src;
    }
}

