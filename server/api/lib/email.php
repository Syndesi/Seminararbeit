<?php
namespace lib;
require_once __DIR__.'./config.php';
use PHPMailer\PHPMailer\PHPMailer;

class email {

  protected $mail    = null;

  public function __construct(){
    $this->config = \lib\getConfig();
    $this->mail = new PHPMailer(true);
    $e = $this->config['settings']['email'];
    $this->mail->SMTPDebug = 0;                        // Enable verbose debug output
    if($e['smtp']){
      $this->mail->isSMTP();                           // Set mailer to use SMTP
    }
    $this->mail->Host       = $e['host'];              // Specify main and backup SMTP servers
    $this->mail->SMTPAuth   = $e['smtpAuth'];          // Enable SMTP authentication
    $this->mail->Username   = $e['email'];             // SMTP username
    $this->mail->Password   = $e['password'];          // SMTP password
    $this->mail->SMTPSecure = $e['smtpSecure'];        // Enable TLS encryption, `ssl` also accepted
    $this->mail->Port       = $e['port'];              // TCP port to connect to
    $this->mail->setFrom($e['email'], $e['username']);
    $this->mail->isHTML(true);                         // Set email format to HTML
  }

  public function testEmail(){
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.project-ozone.de';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'tmp@project-ozone.de';                 // SMTP username
    $mail->Password = ')k7#k_W[Iz*U';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to
    $mail->setFrom('tmp@project-ozone.de', 'Project Ozone');
    $mail->addAddress('soerenklein98@gmail.com', 'Sören Klein');
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->send();
  }

  public function setSubject($subject){
    $this->mail->Subject = $subject;
  }

  public function setBody($body){
    $this->mail->Body = $body;
  }

  public function addAddress($address, $name){
    $this->mail->addAddress($address, $name);
  }

  public function send(){
    $this->mail->send();
  }

}

?>