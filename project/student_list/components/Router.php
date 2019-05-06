<?php

class Router
{
    public $params = [];
	private $routes;

	public function __construct()
	{
        $routesPath     = ROOT.'/config/routes.php';
		$this->routes   = include($routesPath);
    }

    public function getUri()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
			$uri        = preg_replace('#^([\S]+)(student_list[\/])#', '', $_SERVER['REQUEST_URI']);
			return $uri;
		}
    }

    public function match()
    {
        $uri    = $this->getUri();
        foreach ($this->routes as $uriPattern => $path) {

            if(preg_match($uriPattern, $uri)) {
                $rand   = $uriPattern;

                foreach ($path as $file => $class) {
                    $this->params[]     = $file;
                    $this->params[]     = $class;    
                    return true;
                }     
            }
            continue;

        }   
        return false;
    }
    
    public function run()
    {   
        if($this->match()) {
            $controller                 = ROOT.'/controllers/' . $this->params[0] . 'Controller.php';
            
            if(file_exists($controller)) {
                include ($controller);

                $controllerClass        = $this->params[0] . 'Controller';
                
                if(class_exists($controllerClass)){
                    // $controllerMethod   = $this->params[1];
                    $controller         = new $controllerClass;
                    
                }

                // Class not exist/
            }

            // File not exist//
        }
    }
}