<?php

namespace sprint\http\core;

use \sprint\sview\SView;

class Controller 
{    
    public $viewsPath = "";

    public function model($model) 
    {
        if (file_exists('app/models/' . $model . '.php')) 
        {
            $className = "\\sprint\\app\\models\\{$model}";
            return new $className;
        }
    }
    
    public function view(String $view, array $data = [], String $type = "html")
    {
        echo $this->cView($view, $data, $type);
    }

    public function cView(String $view, array $data = [], String $type = "html") 
    {
        ob_start();

        $this->viewsPath = trim($this->viewsPath, "/")."/";
        
        $file = $this->viewsPath . $view . '.php';

        if (file_exists($file)) 
        {
            SView::view($file, $data);
        }else
        {
            throw new \Exception("Views {$view} not found. Please check the path or if the view file exists in the views folder.");
        }
        
        return ob_get_clean();
    }
}
