<?php
namespace sprint\ssession;

use sprint\srequest\SRequest;

/**
 * Class Session
 * @package sprint\app\core
 */
class SSession
{
    /**
     * @return bool
     */
    public static function id()
    {
        // Regenerate session ID to invalidate the old one.
        // Super important to prevent session hijacking/fixation.
        return session_regenerate_id();
    }

    /**
     * @param $key
     */
    public static function setUserIpAgent($key)
    {
        // Regenerate session ID to invalidate the old one.
        // Super important to prevent session hijacking/fixation.
        self::id();
        
        //those values a important to keep track of the user to prevent session hijacking
        self::set($key, array(
            "ip"    => Request::ip(),
            "agent" => Request::agent()
        ));
    }

    /**
     * @param $key
     * @param $value
     * @param bool|false $multi
     */
    public static function set($key, $value, $multi = false)
    {
		if($multi === false)
		{			
        	//here we set session with the specified key and value
	        $_SESSION[$_SERVER['SESSION_KEY']][$key] = $value;
		}else
		{
			$_SESSION[$_SERVER['SESSION_KEY']][$key][] = $value;
		}
    }

    /**
     * @param $key
     * @param $index
     * @param $attribute
     * @param $value
     */
    public static function replace($key, $index, $attribute, $value)
    {
        //here we set session with the specified key and value
        $_SESSION[$_SERVER['SESSION_KEY']][$key][$index][$attribute] = $value;
    }

    /**
     * @param $key
     * @return bool
     */
    public static function get($key)
    {
        //here we get the session value from the specified key
        return !empty($_SESSION[$_SERVER['SESSION_KEY']][$key]) ? $_SESSION[$_SERVER['SESSION_KEY']][$key] : null;
    }

    /**
     * @param $key
     * @return bool
     */
    public static function flash($key)
    {
        //the idea of flash is to unset the value of the session after being displayed at the first time
        //to achieve this point we store in variable the value of the session for the informed key
        $session = self::get($key);
        
        //here we unset the session for the informed key
        self::remove($key);
        
        //here we return the value of the session stored in the variable
        return $session;
    }

    /**
     * @param $key
     * @param null $index
     */
    public static function remove($key, $index = null)
    {
        if(is_string($key))
        {
			if($index !== null)
		   	{
				unset($_SESSION[$_SERVER['SESSION_KEY']][$key][$index]);
		   	}else
			{
				unset($_SESSION[$_SERVER['SESSION_KEY']][$key]);
		   	}
            	
        }else if(is_array($key))
        {
            foreach($key as $indexes)
            {
				if($index !== null)
				{
					unset($_SESSION[$_SERVER['SESSION_KEY']][$indexes][$index]);
				}else
				{
					unset($_SESSION[$_SERVER['SESSION_KEY']][$indexes]);
				}
				
            }
        }
    }
}