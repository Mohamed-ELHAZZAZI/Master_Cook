<?php
class Router
{
    protected $uri;
    protected $controller;
    protected $action;
    protected $parms;
    protected $route;
    protected $method_prefix;




    /**
     * @return mixed
     */

    public function getUri()
    {
        return $this->uri;
    }



    /**
     * @return mixed
     */

    public function getController()
    {
        return $this->controller;
    }



    /**
     * @return mixed
     */

    public function getAction()
    {
        return $this->action;
    }



    /**
     * @return mixed
     */

    public function getParms()
    {
        return $this->parms;
    }



    /**
     * @return mixed
     */

    public function getRoute()
    {
        return $this->route;
    }


    public function setRoute($o)
    {

        $this->route = $o;
    }


    /**
     * @return mixed
     */

    public function getMethodPrefix()
    {
        return $this->method_prefix;
    }







    public function __construct($uri)
    {
        $this->uri = urldecode(trim($uri, '/'));


        //Get Default
        $routes = config::get('routes');
        $this->route = config::get(('default_route'));
        $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
        $this->controller =  config::get(('default_controller'));
        $this->action =  config::get(('default_action'));

        $uri_parts = explode('?', $this->uri);

        //Get path like /controller/action/parm1/parm2
        $path = $uri_parts[0];
        $path_parts = explode('/', $path);


        if (count($path_parts)) {
            if (in_array(strtolower(current($path_parts)), array_keys($routes))) {
                $this->route = strtolower(current($path_parts));
                $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
                array_shift($path_parts);
            }

            //get controller

            if (current($path_parts)) {
                $this->controller = strtolower(current($path_parts));
                array_shift($path_parts);
            }
            //get action

            if (current($path_parts)) {
                $this->action = strtolower(current($path_parts));
                array_shift($path_parts);
            }

            //get parms - 

            $this->parms = $path_parts;
        }
    }
}
