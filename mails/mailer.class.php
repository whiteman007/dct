<?
class mailer{
var $email_to;
var $email_subject;
var $headers;
var $mime_boundary;
var $email_message;

//sets up variables and mail email
function mailer($email_to,$email_subject,$email_message,$headers){
$this->email_to=$email_to;
$this->email_subject=$email_subject;
$this->headers = $headers;
$semi_rand = md5(time());
$this->mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
$this->headers .= "\nMIME-Version: 1.0\n" .
"Content-Type: multipart/mixed;\n" .
" boundary=\"{$this->mime_boundary}\"";
$this->email_message .= "This is a multi-part message in MIME format.\n\n" .
"--{$this->mime_boundary}\n" .
"Content-Type:text/html; charset=\"utf-8\"\n" .
"Content-Transfer-Encoding: 7bit\n\n" .
$email_message . "\n\n";
}

//adds attachment
function attach($fileatt_type,$fileatt_name,$fileatt_content){
$data = chunk_split(base64_encode($fileatt_content));
$this->email_message .= "--{$this->mime_boundary}\n" .
"Content-Type: {$fileatt_type};\n" .
" name=\"{$fileatt_name}\"\n" .
"Content-Transfer-Encoding: base64\n\n" .
$data . "\n\n" .
"--{$this->mime_boundary}\n";
unset($data);
unset($file);
unset($fileatt);
unset($fileatt_type);
unset($fileatt_name);
}

//send email
function send(){
    return mail($this->email_to, $this->email_subject, $this->email_message, $this->headers);
}



//extra functions to make life easier

//send email with imap
function imap_send(){
return imap_mail($this->email_to, $this->email_subject, $this->email_message, $this->headers);
}

//read file and add as attachment
function file($file){
$o=fopen($file,"rb");
$content=fread($o,filesize($file));
fclose($o);
$name=basename($file);
$type="application/octet-stream";
$this->attach($type,$name,$content);
}

//read directory and add files as attachments
function dir($dir){
$o=opendir($dir);
while(($file=readdir($o)) !==false){
if($file != "." && $file != ".."){
if(is_dir($dir."/".$file)){
$this->dir($dir."/".$file);
}else{
$this->file($dir."/".$file);
}}}}

}
?>