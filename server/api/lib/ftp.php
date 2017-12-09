<?php
namespace lib;

class FTP {

  private $ftp = null;

  public function __construct($server){
    $this->ftp = ftp_connect($server);
  }

  public function __destruct(){
    ftp_close($this->ftp);
  }

  public function login($user = 'anonymous', $password = ''){
    return ftp_login($this->ftp, $user, $password);
  }

  public function pasv($status){
    return ftp_pasv($this->ftp, $status);
  }

  /**
   * Returns a path to the downloaded file.
   */
  public function download($path){
    $tmpPath = tempnam(sys_get_temp_dir(), 'ftp');
    $status = ftp_get($this->ftp, $tmpPath, $path, FTP_BINARY);
    if($status){
      return $tmpPath;
    }
    if(is_file($tmpPath)){
      unlink($tmpPath);
    }
    return false;
  }

  public function downloadZip($path){
    $zipPath = $this->download($path);
    $folder = $this->tempdir();
    if($zipPath){
      $zip = new \ZipArchive;
      if($zip->open($zipPath) === true){
        $zip->extractTo($folder);
        $zip->close();
        unlink($zipPath);
        return $folder;
      }
    }
    return false;
  }

  private function tempdir(){
    $tempfile=tempnam(sys_get_temp_dir(),'');
    if(file_exists($tempfile)){ unlink($tempfile);}
    mkdir($tempfile);
    if(is_dir($tempfile)){ return $tempfile;}
  }

  public function scandir($path){
    return ftp_nlist($this->ftp, $path);
  }

}

?>