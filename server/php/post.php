<?php

//данные из post:
$topic = $_POST['topic'];
$email = $_POST['email'];
$message = $_POST['message'];
$admin_email = "admin@mail.ru";

$msg = '';

require 'class.phpmailer.php';
$mail = new PHPMailer;
$mail->setFrom($admin_email);
$mail->addAddress($email);
$mail->Subject = $topic;
$mail->Body = $message;
//Attach multiple files one by one

$files_server = scandir('files');

//отправка файлов:
for ($i=0; $i<count($files_server); $i++)
{
    if (is_file('files/'.$files_server[$i]))
    {
        $mail->addAttachment('files/'.$files_server[$i]);

    }
}

// вывод сообщений
if (!$mail->send()) {
    $msg .= "Ошибка отправки сообщения: " . $mail->ErrorInfo;
} else {
    $msg .= "Сообщение отправлено!";
}

$_SESSION['msg'] = $msg;


//удаление файлов:
for ($i=0; $i<count($files_server); $i++)
{
    if (is_file('files/'.$files_server[$i]))
    {
        unlink('files/'.$files_server[$i]);
    }
}

//удаление маленьких файлов:
$nails_server =scandir('files/thumbnail');

for ($i=0; $i<count($nails_server); $i++)
{
    if (is_file('files/thumbnail/'.$nails_server[$i]))
    {
        unlink('files/thumbnail/'.$nails_server[$i]);
    }
}

require ('sent.php');