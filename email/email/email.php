<?php


/**
 *
 */
class email
{
    static private $mail;

    static private $password = "BQKMUCJRGPVGQIAK";
    static private $username = "camel_nsg@163.com";
    static private $host = "smtp.163.com";
    static private $from = "bitCoin";

    public static function init()
    {
        self::$mail = new \PHPMailer\PHPMailer\PHPMailer;


    }

    public static function send($to, $title, $content)
    {
        self::init();
        //使用smtp鉴权方式发送邮件
        self::$mail->isSMTP();
        //smtp需要鉴权 这个必须是true
        self::$mail->SMTPAuth = true;
        // qq 邮箱的 smtp服务器地址，这里当然也可以写其他的 smtp服务器地址
        self::$mail->Host = self::$host;
        //smtp登录的账号 这里填入字符串格式的qq号即可
        self::$mail->Username = self::$username;
        // 这个就是之前得到的授权码，一共16位
        self::$mail->Password = self::$password;

        self::$mail->setFrom(self::$username, self::$from);
        // $to 为收件人的邮箱地址，如果想一次性发送向多个邮箱地址，则只需要将下面这个方法多次调用即可
        self::$mail->addAddress($to);
        // 该邮件的主题
        self::$mail->Subject = $title;
        // 该邮件的正文内容
        self::$mail->Body = $content;

        // 使用 send() 方法发送邮件
        if (!self::$mail->send()) {
            return 'error: ' . self::$mail->ErrorInfo;
        } else {
            return "success";
        }
    }

}

