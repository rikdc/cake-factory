<?php

App::uses('File', 'Utility');
class Factory extends Object{

  public $options = array();

  function __construct($model){
    $this->options['model'] = $model;

    $file = new File(FACTORY . DS . "{$model}.json");
    $this->options['default'] = json_decode($file->read(), true);

    $this->options['counter'] = array(); 
  }

  private function checkCounter($key, $value){
    if(strstr($value, '#{n}')){
      if(!array_key_exists($key, $this->options['counter'])) $this->options['counter'][$key] = 0;
      $this->options['counter'][$key]++;

      $value = str_replace('#{n}', $this->options['counter'][$key], $value);
    }
    return $value;
  }

  function build($attributes = array()){
    $data = array_merge($this->options['default'], $attributes);
    $object = array();    

    foreach($data as $key => $value){
      $object[$this->options['model']][$key] = $this->checkCounter($key, $value);
    }
    return $object;
  }

  function create($attributes = array()){}
}