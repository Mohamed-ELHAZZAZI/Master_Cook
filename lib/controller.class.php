<?php

class Controller
{
    protected $data;
    protected $model;
    protected $parms;

    /**
     * 
     * @return mixed
     * 
     */

    public function getData()
    {
        return $this->data;
    }

    /**
     * 
     * @return mixed
     * 
     */

    public function getModel()
    {
        return $this->model;
    }



    /**
     * 
     * @return mixed
     * 
     */

    public function getParms()
    {
        return $this->parms;
    }


    public function __construct($data = array ())
    {
        $this->data = $data;
        $this->parms = App::getRouter()->getParms();
    }
}
