<?php

namespace App\Facades;

use Laravel\Ui\UiServiceProvider;

abstract class MainFacade{

    private object $data;
    private int $code;

    public function __construct(){
        
    }

    public function set(object $data):object{
        $this->data = $data;
        return $this;
    }

    public function get(string|null $property = false){

        if (!$property){
            return $this->data;
        }else{
            return $this->getProperty($property);   
        }

    }

    protected function getProperty(string $property){

        $property = explode('.', $property);
        if (count($property) == 1){
            return isset($this->data->{$property[0]}) ? $this->data->{$property[0]} : null;
        }

        $value = $this->data;

        foreach ($property as $p){
            if (!$this->has($p)) return null;
            $value = $value->{$p};
        }

        return $value;

    }

    public function has($property = false){

        if ($this->response()->isFail()) return false;

        return isset($this->data->{$property});

    }

}