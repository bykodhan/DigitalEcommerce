<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

function send_mail($to_adres, $subject, $body)
{
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0; //Enable verbose debug output
        $mail->CharSet = PHPMailer::CHARSET_UTF8;
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = Cache::get('mail_host'); //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = Cache::get('mail_username'); //SMTP username
        $mail->Password = Cache::get('mail_password'); //SMTP password
        $mail->SMTPSecure = Cache::get('mail_secure'); //Enable implicit TLS encryption
        $mail->Port = Cache::get('mail_port'); //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        //$mail->SMTPKeepAlive = true; //sürekli mail gönderme

        //Recipients
        $mail->setFrom(Cache::get('mail_from_adress'), Cache::get('mail_from_name'));
        $mail->addAddress($to_adres); //Add a recipient

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $body;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
function money($price)
{
    return number_format($price, 2, ',', '.');
}

function array_zip_combine(array $keys, ...$arrs)
{
    return array_map(function (...$values) use ($keys) {
        return array_combine($keys, $values);
    }, ...$arrs);
}
function private_str($str)
{
    $start = 2;
    $end = 7;
    $after = mb_substr($str, 0, $start, 'utf8');
    $repeat = str_repeat('*', $end);
    $before = mb_substr($str, ($start + $end), strlen($str), 'utf8');
    return $after . $repeat . $before;
}
function telegram_bot_send_message($message)
{
    $token = Cache::get('telegram_bot_token');

    $parametre = array(
        'chat_id' => Cache::get('telegram_bot_chat_id'),
        'text' => $message,
    );
    $ch = curl_init();
    $url = "https://api.telegram.org/bot" . $token . "/sendmessage";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parametre);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    if(json_decode($result)->ok){
        return true;
    }else{
        return false;
    }
}
