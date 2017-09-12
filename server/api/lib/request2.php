<?php
namespace lib;

use Symfony\Component\Yaml\Yaml;
include_once 'xml.php';
include_once 'session.php';
include_once 'util.php';

class Request {

  public $api;
  public $route;
  public $data  = [];
  public $files = [];
  public $format;         // json/xml/yaml
  public $method;         // GET/POST/PUT/DELETE
  private $clientHeaders;
  public $indent = true;
  protected $rawInput;
  protected $timestamp;

  const DATE_FORMAT        = 'Y-m-dTH:i:s';
  const FORMAT_JSON        = 'application/json';
  const FORMAT_XML         = 'application/xml';
  const FORMAT_YAML        = 'application/x-yaml';
  const FORMAT_URL_ENCODED = 'application/x-www-form-urlencoded';
  const FORMAT_FORM_DATA   = 'multipart/form-data';
  const PATH_NAME          = '_PATH';

  public function __construct(){
    $this->timestamp = gmdate($this::DATE_FORMAT);
    $this->rawInput = file_get_contents('php://input');
    $this->clientHeaders = getallheaders();
    $this->format = $this->getOutputformat();
    $this->method = $this->getMethod();
    parseRawData();
    $this->session = new session();

    $this->parseRoute();
  }

  private function getMethod(){
    $method = $_SERVER['REQUEST_METHOD'];
    if(array_key_exists('method', $this->clientHeaders)){
      $method = $this->clientHeaders['method'];
    }
    if($this->isData('method')){
      $method = $this->data['method'];
      unset($this->data['method']);
    }
    if($this->isData('m')){
      $method = $this->data['m'];
      unset($this->data['m']);
    }
    $method = strtoupper(trim($method));
    return $method;
  }

  private function parseRoute(){
    // get the remaining URL, delivered by .htaccess
    $path = explode('/', trim($_GET[$this::PATH_NAME], '/'));
    if(count($path) == 0 || !$path[0]){
      throw new Exception('No API specified.');
    }
    $this->api = array_shift($path);
    $this->route = $this->method.':/'.implode('/', $this->path);
  }

  private function getOutputformat(){
    $format = $this::FORMAT_JSON;
    if(array_key_exists('Content-Type', $this->clientHeaders)){
      $format = $this->clientHeaders['Content-Type'];
    }
    if(array_key_exists('Accept', $this->clientHeaders)){
      $format = $this->clientHeaders['Accept'];
    }
    if(array_key_exists('format', $this->data)){
      $format = $this->data['format'];
      unset($this->data['format']);
    }
    if(array_key_exists('f', $this->data)){
      $format = $this->data['f'];
      unset($this->data['f']);
    }
    $format = explode(';', $format)[0];
    return $this->parseFormat($format);
  }

  private function getRawDataformat(){
    $format = $this::FORMAT_JSON;
    if(array_key_exists('Content-Type', $this->clientHeaders)){
      $format = explode(';', $this->clientHeaders['Content-Type'])[0];
    }
    return $this->parseFormat($format);
  }

  private function parseRawData(){
    $data = [];
    $files = [];
    if(!in_array($_SERVER['REQUEST_METHOD'], ["GET", "COPY", "PURGE", "UNLOCK"])){
      // HTTP-Requests with no body can´t save body-data
      $format = $this->getRawDataformat();
      switch($format){
        case $this::FORMAT_URL_ENCODED:
          parse_str($this->rawInput, $data);
          break;
        case $this::FORMAT_FORM_DATA:
          $data = $_POST;
          $files = $_FILES;
          break;
        case $this::FORMAT_XML:
          $data = xml2array($this->rawInput);
          break;
        case $this::FORMAT_YAML:
          $data = Yaml::parse($this->rawInput);
          break;
        case $this::FORMAT_JSON:
        default:
          $data = json_decode($this->rawInput, true);
          break;
      }
      if(!is_array($this->data)){
        throw new Exception('Error while parsing the request.');
      }
    }
    if(count($_GET) > 0){
      $data = array_merge($_GET, $data);
      if(array_key_exists($this::PATH_NAME, $data)){
        unset($data[$this::PATH_NAME]);
      }
    }
    $this->data = $data;
    $this->files = $files;
  }

  private function parseFormat($format){
    $format = strtolower(trim($format));
    switch($format){
      case 'application/xml':
      case 'text/xml':
      case 'xml':
        $format = $this::FORMAT_XML;
        break;
      case 'application/x-yaml':
      case 'application/x-yml':
      case 'application/yaml':
      case 'application/yml':
      case 'text/yaml':
      case 'text/yml':
      case 'yaml':
      case 'yml':
        $format = $this::FORMAT_YAML;
        break;
      case 'application/x-www-form-urlencoded':
        $format = $this::FORMAT_URL_ENCODED;
        break;
      case 'multipart/form-data':
        $format = $this::FORMAT_FORM_DATA;
        break;
      case 'application/json':
      case 'text/json':
      case 'json':
      default:
        $format = $this::FORMAT_JSON;
        break;
    }
    return $format;
  }

}

?>