<?php
function format_email($info, $format) {
  //set the root
  $root = $_SERVER['DOCUMENT_ROOT'].'/dev/tutorials/email_signup';

  //grab the template content
  $template = file_get_contents($root.'/signup_template.'.$format);

  //replace all the tags
  $template = ereg_replace('{USERNAME}', $info['username'], $template);
  $template = ereg_replace('{EMAIL}', $info['email'], $template);
  $template = ereg_replace('{KEY}', $info['key'], $template);
  $template = ereg_replace('{SITEPATH}','http://site-path.com', $template);

  //return the html of the template
  return $template;
}

function send_email($info){
    //format each email
    $body = format_email($info,'html');
    $body_plain_txt = format_email($info,'txt');

    //setup the mailer
    $transport = Swift_MailTransport::newInstance();
    $mailer = Swift_Mailer::newInstance($transport);
    $message = Swift_Message::newInstance();
    $message ->setSubject('Welcome to Site Name');
    $message ->setFrom(array('noreply@todolister.com' => 'Site Name'));
    $message ->setTo(array($info['email'] => $info['username']));

    $message ->setBody($body_plain_txt);
    $message ->addPart($body, 'text/html');

    $result = $mailer->send($message);

    return $result;

}



?>
