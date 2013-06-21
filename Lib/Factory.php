<?php

App::uses('File', 'Utility');
class Factory extends Object{

  public static $counter = array();


  private static function init($model){
    $file = new File(FACTORY . DS . "{$model}.json");
    return json_decode($file->read(), true);
  }

  private static function checkCounter($key, $value){
    if($value === null) return $value;
    if(is_array($value)){
      $model = $value['model'];
      return Factory::create($model)->field('id');
    }

    if(strstr($value, '#{n}')){
      if(!array_key_exists($key, self::$counter)) self::$counter[$key] = 0;
      self::$counter[$key]++;

      $value = str_replace('#{n}', self::$counter[$key], $value);
    }
    return $value;
  }

  /**
   * 
   * 
   */
  public static function values($model, $attributes = array()){
    $model = str_replace(' ', '', ucwords(str_replace('_', ' ', $model)));
    $json = self::init($model);

    $data = array_merge($json, $attributes);
    $object = array();    

    foreach($data as $key => $value){
      $object[$model][$key] = self::checkCounter($key, $value);
    }

    return $object;
  }

  /**
   * 
   * Build the object
   */
  public static function build($model, $attributes = array()){
    $model = str_replace(' ', '', ucwords(str_replace('_', ' ', $model)));
    $json = self::init($model);

    $data = array_merge($json, $attributes);
    $object = array();    

    foreach($data as $key => $value){
      $object[$model][$key] = self::checkCounter($key, $value);
    }

    $Model = ClassRegistry::init($model);
    $Model->useDbConfig = 'test';
    $Model->create();
    $Model->set($object);

    return $Model;
  }

  public static function create($model, $attributes = array()){
    $Model = self::build($model, $attributes);

    $Model->save();

    return $Model;
  }

}