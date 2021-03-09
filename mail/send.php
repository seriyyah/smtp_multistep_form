<?php
// Файлы phpmailer
require 'class.phpmailer.php';
require 'class.smtp.php';

// getting posts by name
$price= $_POST['price'];
$model = $_POST['img_swap_id'];
$structure = $_POST['img_swap_id_f'];
$front_length = $_POST['front_length'];
$left_length = $_POST['left_length'];
$right_length = $_POST['right_length'];

$name = $_POST['mf_name'];
$number = $_POST['mf_phone'];
$new_post = $_POST['mf_email'];

$mail_body = "Почта: $new_post<br>Имя: $name <br>Номер: $number ";
$size = "Длина фронтальной части: $front_length (м | см | мм) <br> Длина левой части: $left_length (м | см | мм)<br>Длина правой части: $right_length (м | см | мм)";


// Настройки
$mail = new PHPMailer;
$mail->isSMTP(); 
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = ''; // Ваш логин в .
$mail->Password = ''; // Ваш пароль
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;
$mail->setFrom(''); // Ваш Email
$mail->addAddress(''); // Email получателя
$mail->CharSet = 'UTF-8';
$mail->SMTPOptions = [
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    ]
];
// $mail->addAddress('example@gmail.com'); // Еще один email, если нужно.
// Прикрепление файлов
 for ($ct = 0; $ct < count($_FILES['userfile']['tmp_name']); $ct++) {
 $uploadfile = tempnam(sys_get_temp_dir(), sha1($_FILES['userfile']['name'][$ct]));
 $filename = $_FILES['userfile']['name'][$ct];
 if (move_uploaded_file($_FILES['userfile']['tmp_name'][$ct], $uploadfile)) {
 $mail->addAttachment($uploadfile, $filename);
 } else {
 $msg .= 'Failed to move file to ' . $uploadfile;
 }
 } 
 
// Письмо
$mail->isHTML(true); 
$mail->Subject = "Заголовок"; // Заголовок письма
$mail->Body = "<html>
<head>
<title>HTML email</title>
</head>
<body>

<table>
<thead>
  <tr>
    <th>Предполагаемая стоимость кухни:</th>
    <th>  $price.руб</th>
    <th></th>
  </tr>
</thead>
<tbody>
  <tr>
    <td>Модель кухни:</td>
    <td> $model</td>
    <td></td>
  </tr>
  <tr>
    <td>Форма кухни: </td>
    <td> $structure</td>
    <td></td>
  </tr>
  <tr>
    <td>Размеры гарнитура: </td>
    <td> $size</td>
    <td></td>
  </tr>
  <tr>
    <td>Персональные данные:</td>
    <td>$mail_body</td>
    <td></td>
  </tr>
</tbody>
</table>
</body>
</html>"; // Текст письма
// Результат
if(!$mail->send()) {
 echo 'Message could not be sent.';
 echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
 echo 'ok';
}
?>