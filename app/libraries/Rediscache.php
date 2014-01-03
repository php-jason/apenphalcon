<?php
class Rediscache{
  protected $_config = array(
    'host'   => '127.0.0.1',
    'port'   => 6379,
    'timeout'  => 0
  );
  public $redis=null;
  public $expire = 3600;
  public function __construct() {
    $this->redis=new Redis();
    $this->redis->pconnect($this->_config['host'],$this->_config['port'],$this->_config['timeout']);
  }
  public function set($key,$data){
    try{
      $this->redis->setex($key,$this->expire,$data);
    }catch(Exception $e){
    }
  }
  
  public function mset($data){
    if(is_array($data))
      return $this->redis->mset($data);
    else
      return false;
  } 
 
  public function get($key){
    try{
      if(is_array($key))
        return $this->redis->getMultiple($key);
      else
        return $this->redis->get($key);
    }catch(Exception $e){
      return null;
    }
  }
  public function sort($key,$option){
    return $this->redis->sort($key,$option);
  }
  public function incr($key){
    $this->redis->incr($key);
  }
  public function keys($key){
    return $this->redis->keys($key);
  }
  public function delete($key){
    $this->redis->delete($key);
  }
}
?>
