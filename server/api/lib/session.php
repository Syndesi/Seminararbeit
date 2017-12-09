<?php
namespace lib;

class session{

  public function __construct(){
    session_start();
  }

  /**
   * Destroys the current session.
   */
  public function destroy(){
    session_unset();
    session_destroy();
  }

  /**
   * Destroys the current session and starts a new one.
   */
  public function restart(){
    $this->destroy();
    session_start();
  }

  /**
   * Sets a variable in the session.
   * @param string $id The key of the variable.
   * @param *      $v  The variable which should be stored.
   */
  public function set($key, $v){
    $_SESSION[$key] = $v;
  }

  /**
   * Returns a variable from the session or false if it isn't found.
   * @param  string    $key The key of the variable.
   * @return *|boolean      The variable or false if it wasn't found.
   */
  public function get($key){
    if(isset($_SESSION[$key])){
      return $_SESSION[$key];
    }
    return false;
  }

}

?>