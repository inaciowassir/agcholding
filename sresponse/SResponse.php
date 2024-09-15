<?php 
namespace sprint\sresponse;

class SResponse
{    
    public static function setCode(int $code)
	{
		http_response_code($code);
	}
    
    public static function type(String $type = "")
    {
        switch ($type) 
        {
            case 'xml':
                header('Content-type: text/xml; charset=UTF-8');
                break;
            case 'json':
                header("Content-Type: application/json; charset=UTF-8");
                break;
            default:
                header("Content-Type: text/html; charset=UTF-8");
        }
    }
    
    public static function redirect(String $url = "", int $code = 301)
    {
		$appDomain = trim($_SERVER["APP_DOMAIN"], "/");
		$url = trim($url, "/");
		
        header("Location: ". $appDomain . "/" . $url, true, $code);        
        exit();
    }
    
}