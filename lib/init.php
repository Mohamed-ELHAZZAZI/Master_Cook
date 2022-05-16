<?php

require_once(ROOT.S.'config'.S.'config.php');
function __autoload($class_name) {
    $lib_path = ROOT.S.'lib'.S.strtolower($class_name).'.class.php';
    $controllers_path = ROOT.S.'controllers'.S.str_replace('controller','',strtolower($class_name)).'.controller.php';
    $model_path = ROOT.S.'models'.S.strtolower($class_name).'.php';


    if (file_exists($lib_path)) {
        require_once($lib_path);
    }elseif (file_exists($controllers_path)) {
        require_once($controllers_path);
    }elseif (file_exists($model_path)) {
        require_once($model_path);
    }else {
        throw new Exception('Failed to include class:'.$class_name);
    }
}

