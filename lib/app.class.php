<?php
class App
{
    protected static $router;

    public static $db;



    /**
     * @return mixed
     * 
     */

    public static function getRouter()
    {
        return self::$router;
    }

    public static function run($uri)
    {
        self::$router = new Router($uri);
        $controller_class = ucfirst(self::$router->getController()) . 'Controller';
        $controller_method = strtolower(self::$router->getMethodPrefix() . self::$router->getAction());


        self::$db = new DB(config::get('db.host'), config::get('db.user'), config::get('db.password'), config::get('db.db_name'));

        //calling controllers method

        $controller_object = new $controller_class();
        if (method_exists($controller_object, $controller_method)) {
            ///controller's action may return a view pathh
            $view_path = $controller_object->$controller_method();
            $view_object = new View($controller_object->getData(), $view_path);
            $content = $view_object->render();
        } else {
            throw new Exception('Method ' . $controller_method . ' of class ' . $controller_class . ' does not exists');
        }

        if ($controller_class == LoginController::class || $controller_class == RegisterController::class) {
            self::$router->setRoute("login");
        }

        $layout  = self::$router->getRoute();


        $layout_path = VIEWS_PATH . S . $layout . '.html';
        $layout_view_object = new View(compact('content'), $layout_path);
        echo $layout_view_object->render();
    }
}
