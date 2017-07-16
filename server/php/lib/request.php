<?php
namespace lib;

use Symfony\Component\Yaml\Yaml;
include_once 'xml.php';
include_once 'commonUtil.php';

class request{

  public $api;
  public $method;
  public $status;
  public $timestamp;
  public $clientHeaders;
  public $format;         // the format which is returned (e.g. 'json', 'yml' or 'xml')
  public $data = [];
  public $file = [];
  public $indent = true;
  protected $rawInput;

  const FORMAT_JSON = 'application/json';
  const FORMAT_XML  = 'application/xml';
  const FORMAT_YAML = 'application/x-yaml';

  const PATH_NAME       = '__PATH';

  const OK                 = 'OK';
  const REQUEST_DENIED     = 'REQUEST_DENIED';
  const INVALID_REQUEST    = 'INVALID_REQUEST';
  const UNKNOWN_ERROR      = 'UNKNOWN_ERROR';

  public function __construct(){
    $this->timestamp = gmdate('Y-m-dTH:i:sZ');
    $this->clientHeaders = getallheaders();
    $this->rawInput = file_get_contents('php://input');
    $this->format = $this::FORMAT_JSON;
    $this->status = $this::OK;

    $this->parseClientRequest();
    $this->overwriteFormat();

    $path = explode('/', trim($_REQUEST[$this::PATH_NAME], '/'));
    if(count($path) == 0 || !$path[0]){
      $this->abort($this::INVALID_REQUEST, 'No API specified');
    }
    $this->api = array_shift($path);
    $this->getMethod(array_shift($path));
  }

  /**
   * Trys to get the method
   * @param  string $arg given method
   * @return void      nothing
   */
  protected function getMethod($arg){
    $method = false;
    if(array_key_exists('method', $this->data)){
      $method = $this->data['method'];
      unset($this->data['method']);
    }
    if($arg !== ""){
      $method = $arg;
    }
    $this->method = $method;
  }

  /**
   * parses the received data from the client. It was somewhat difficult to add all edge-cases
   * @return void
   */
  public function parseClientRequest(){
    if(!in_array($_SERVER['REQUEST_METHOD'], ["GET", "COPY", "PURGE", "UNLOCK"])){
      if(array_key_exists('Content-Type', $this->clientHeaders)){
        $contentType = explode(';', $this->clientHeaders['Content-Type'])[0];
        switch($contentType){
          case 'application/xml':
          case 'text/xml':
            $data = xml2array($this->rawInput);
            $this->format = $this::FORMAT_XML;
            break;
          case 'application/x-yaml':
          case 'text/yaml':
            $data = Yaml::parse($this->rawInput);
            $this->format = $this::FORMAT_YAML;
            break;
          case 'application/x-www-form-urlencoded':
            parse_str($this->rawInput, $this->data);
            break;
          case 'multipart/form-data':
            $data = $_POST;
            $this->file = $_FILES;
            break;
          case 'application/json':
          case 'text/plain':
          default:
            $data = json_decode($this->rawInput, true);
            $this->format = $this::FORMAT_JSON;
            break;
        }
        if($data){
          $this->data = $data;
        }
      }
      if(!is_array($this->data)){
        $this->abort($this::INVALID_REQUEST, 'error while parsing the request');
      }
    }
    if(count($_GET) > 0){
      $this->data = array_merge($_GET, $this->data);
      if(array_key_exists('__PATH', $this->data)){
        unset($this->data['__PATH']);
      }
    }
  }

  /**
   * checks if the user want a special format. if it's supported by this application, it will be used
   * @param string $format the default format
   * @return void
   */
  protected function overwriteFormat($format = false){
    // priority:
    // 1.: argument named format
    // 2.: Header: Content-Type
    // 3.: Header: Accept
    if(!$format){
      $format = $this::FORMAT_JSON;
    }
    if(array_key_exists('Accept', $this->clientHeaders)){
      $format = $this->clientHeaders['Accept'];
    }
    if(array_key_exists('Content-Type', $this->clientHeaders)){
      $format = $this->clientHeaders['Content-Type'];
    }
    if(array_key_exists('format', $this->data)){
      $format = $this->data['format'];
      unset($this->data['format']);
    }
    $format = explode(';', $format)[0];
    switch($format){
      case 'application/xml':
      case 'text/xml':
      case 'xml':
        $format = $this::FORMAT_XML;
        break;
      case 'application/x-yaml':
      case 'application/yaml':
      case 'text/yaml':
      case 'text/yml':
      case 'yaml':
      case 'yml':
        $format = $this::FORMAT_YAML;
        break;
      case 'application/json':
      case 'text/json':
      case 'json':
      default:
        $format = $this::FORMAT_JSON;
        break;
    }
    $this->format = $format;
  }

  /**
   * returns received data or aborts the program, if enabled
   * @param  string  $key   the data-key
   * @param  boolean $abort true: the program will abort if the key isn't found, false: this function will return just false if the key isn't found
   * @return data         the received data
   */
  public function getData($key, $abort = false){
    if(array_key_exists($key, $this->data)){
      return $this->data[$key];
    } else {
      if($abort){
        $this->abort($this::INVALID_REQUEST, 'Argument `'.$key.'` not found.');
      } else {
        return null;
      }
    }
  }

  /**
   * checks if the client has send a special type of data
   * @param  string  $key the data-key
   * @return boolean      true: data was sent, false: data wasn't sent
   */
  public function isData($key){
    if(array_key_exists($key, $this->data)){
      if($this->data[$key] !== NULL && $this->data[$key] != ''){
        return true;
      }
    } else {
      return false;
    }
  }

  /**
   * This function is used to finish the program
   * @param  object $obj the result, will be encoded as JSON/XML/YAML
   * @return void
   */
  public function finish($obj){
    $this->out($obj);
  }

  /**
   * This function is used to abort the program
   * @param  string $status  the status of the program
   * @param  string $message explanation for the error
   * @return void
   */
  public function abort($status, $message){
    $this->out(null, $status, $message);
  }

  /**
   * This function returns the response with several additional informations
   * @param  object  $result        the result, if finished
   * @param  string $status        the staus code, e.g. 'OK'
   * @param  string  $error_message the error-message, default is null
   * @return void                 exit before return
   */
  protected function out($result, $status = false, $error_message = null){
    if(!$status){
      $status = $this::OK;
    }
    header('X-Powered-By: Syndesi´s hamsters');
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Credentials: true");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
    header('Accept: application/json, application/xml, text/xml, application/x-yaml, text/yaml, application/x-www-form-urlencoded, multipart/form-data');
    header('Content-Type: '.$this->format.'; charset=utf-8');
    $obj = [
      'result'        => $result,
      'status'        => $status,
      'error_message' => $error_message,
      'environment'   => [
        'api'           => $this->api,
        'method'        => $this->method,
        'requestMethod' => $_SERVER['REQUEST_METHOD'],
        'timestamp'     => $this->timestamp,
        'data'          => $this->data
      ]
    ];
    if(count($this->file) > 0){
      $files = [];
      foreach($this->file as $key => $file){
        $files[$key] = [
          "name"   => $file['name'],
          "type"   => $file['type'],
          "size"   => \lib\formatBytes($file['size'])
        ];
        $status = $this->getFileErrorCode($file['error']);
        $files[$key]['status'] = $status[0];
        if($status[1]){
          $files[$key]['error_message'] = $status[1];
        }
      }
      $obj['environment']['file'] = $files;
    }
    if($error_message === null){
      unset($obj['error_message']);
    } else {
      unset($obj['result']);
    }
    switch($this->format){
      case $this::FORMAT_YAML:
        if($this->indent){
          $data = Yaml::dump($obj, 10, 2);
        } else {
          $data = Yaml::dump($obj, 0, 2);
        }
        break;
      case $this::FORMAT_XML:
        if($this->indent){
          $dom = new \DOMDocument;
          $dom->loadXML(array2xml($obj));
          $dom->formatOutput = true;
          $data = $dom->saveXML();
        } else {
          $data = array2xml($obj);
        }
        break;
      case $this::FORMAT_JSON:
      default:
        if($this->indent){
          $data = json_encode($obj, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
          $data = json_encode($obj, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        break;
    }
    // this line returns the whole response
    echo($data);
    exit;
  }

  /**
   * Returns the explanation for several error-codes, which occur while uploading files.
   * @param  int $code the native php-error-code
   * @return array       [0]: 'OK' or 'ERROR', [1]: false or the error explanation
   */
  protected function getFileErrorCode($code){
    switch($code){
      case UPLOAD_ERR_OK:
        return ['OK', false];
      case UPLOAD_ERR_INI_SIZE:
        return ['ERROR', 'File must be smaller than '.(ini_get('upload_max_filesize')/(1024*1024)).' mb'];
      case UPLOAD_ERR_FORM_SIZE:
        return ['ERROR', 'File exceeds the MAX_FILE_SIZE directive that was specified in the HTML form'];
      case UPLOAD_ERR_PARTIAL:
        return ['ERROR', 'File was only partially uploaded'];
      case UPLOAD_ERR_NO_FILE:
        return ['ERROR', 'No File was uploaded'];
      case UPLOAD_ERR_NO_TMP_DIR:
      case UPLOAD_ERR_CANT_WRITE:
      case UPLOAD_ERR_EXTENSION:
      default:
        return ['ERROR', 'Internal error while processing the file.'];
    }
  }

}

?>