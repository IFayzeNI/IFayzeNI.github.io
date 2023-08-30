<?php
// Файлы phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

# проверка, что ошибки нет
if (!error_get_last()) {

    // Переменные, которые отправляет пользователь

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    
    
    // Формирование самого письма
    $title = "Данные";
    $body = "
    <h2>Пользователь оставил данные</h2>
    <b>Имя:</b> $name<br>
    <b>Номер телефона:</b> $phone<br>
    <b>E-mail:</b> $email
    ";
    
    // Настройки PHPMailer
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    //$mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['data']['debug'][] = $str;};
    
    // Настройки вашей почты
    $mail->Host       = 'smtp.gmail.com'; // SMTP сервера вашей почты
    $mail->Username   = 'fayzen.kurenkov2@gmail.com'; // Логин на почте
    $mail->Password   = 'aokfxakazisatnwj'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('fayzen.kurenkov2@gmail.com', 'Pulsometer'); // Адрес самой почты и имя отправителя
    
    // Получатель письма
    $mail->addAddress('caraf96421@vikinoko.com');  
    // $mail->addAddress('poluchatel2@gmail.com'); // Ещё один, если нужен
    
    // Прикрипление файлов к письму
    // if (!empty($file['name'][0])) {
    //     for ($i = 0; $i < count($file['tmp_name']); $i++) {
    //         if ($file['error'][$i] === 0) 
    //             $mail->addAttachment($file['tmp_name'][$i], $file['name'][$i]);
    //     }
    // }
    // Отправка сообщения
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;    
    
    // Проверяем отправленность сообщения
    if ($mail->send()) {
        $data['result'] = "success";
        $data['info'] = "Сообщение успешно отправлено!";
    } else {
        $data['result'] = "error";
        $data['info'] = "Сообщение не было отправлено. Ошибка при отправке письма";
        $data['desc'] = "Причина ошибки: {$mail->ErrorInfo}";
    }
    
} else {
    $data['result'] = "error";
    $data['info'] = "В коде присутствует ошибка";
    $data['desc'] = error_get_last();
}

// Отправка результата
header('Content-Type: application/json');
echo json_encode($data);

?>