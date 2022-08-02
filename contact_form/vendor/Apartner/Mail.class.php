<?php
namespace Apartner;

/**
 * Powerful Class to send emails with PHP.
 *
 * @package   Apartner
 * @author    Roman Matviy <roman@matviy.pp.ua>
 * @site      https://roman.matviy.pp.ua
 * @copyright 2022 Roman Matviy <roman@matviy.pp.ua>
 */

class Mail
{
    protected $to;
    protected $from;
    protected $sender;
    protected $sender_email;
    protected $email_copy;
    protected $email_log;
    protected $subject;
    protected $html;

    public function setTo($to)
    {
        $this->to = $to;
    }

    public function setFrom($from)
    {
        $this->from = $from;
    }

    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    public function setEmailCopy($email_copy)
    {
        $this->email_copy = $email_copy;
    }

    public function setEmailLog($email_log)
    {
        $this->email_log = $email_log;
    }

    public function setSenderEmail($sender_email)
    {
        $this->sender_email = $sender_email;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function setHtml($html)
    {
        $this->html = $html;
    }

    public function send()
    {
        date_default_timezone_set('America/New_York');
        // $date = date('F j, Y, g:i a');
        $date = date('D, d M Y H:i:s O');

        $boundary = '----=_NextPart_' . md5(time());

        $header   = 'MIME-Version: 1.0' . PHP_EOL;
        $header .= 'To: <' . $this->to . '>' . PHP_EOL;
        $header .= 'Date: ' . $date . PHP_EOL;
        $header .= 'From: =?UTF-8?B?' . base64_encode($this->sender) . '?= <' . $this->sender_email . '>' . PHP_EOL;
        $header .= 'Reply-To: =?UTF-8?B?' . base64_encode($this->sender) . '?= <' . $this->sender_email . '>' . PHP_EOL;

        // if ($this->email_copy) {
        //     $header .= 'Cc: =?UTF-8?B?' . base64_encode($this->sender) . '?= <' . $this->email_copy . '>' . PHP_EOL;
        // }

        // if ($this->email_log) {
        //     $header .= 'Cc: =?UTF-8?B?' . base64_encode($this->sender) . '?= <' . $this->email_log . '>' . PHP_EOL;
        // }

        $header .= 'Return-Path: ' . $this->from . PHP_EOL;
        $header .= 'X-Mailer: PHP/' . phpversion() . PHP_EOL;
        $header .= 'X-Priority: 3' . PHP_EOL;
        $header .= 'MIME-Version: 1.0' . PHP_EOL;
        $header .= 'Message-ID: ' . '<' . md5(uniqid(rand(), true)) . '@' . $_SERVER['HTTP_HOST'] . '>' . PHP_EOL;
        $header .= 'Content-Type: multipart/mixed; boundary="' . $boundary . '"' . PHP_EOL . PHP_EOL;

        $message  = '--' . $boundary . PHP_EOL;
        $message .= 'Content-Type: multipart/alternative; boundary="' . $boundary . '_alt"' . PHP_EOL . PHP_EOL;
        $message .= '--' . $boundary . '_alt' . PHP_EOL;
        $message .= 'Content-Type: text/plain; charset="utf-8"' . PHP_EOL;
        $message .= 'Content-Transfer-Encoding: 8bit' . PHP_EOL . PHP_EOL;

        $message .= '--' . $boundary . '_alt' . PHP_EOL;
        $message .= 'Content-Type: text/html; charset="utf-8"' . PHP_EOL;
        $message .= 'Content-Transfer-Encoding: 8bit' . PHP_EOL . PHP_EOL;
        $message .= $this->html . PHP_EOL;
        $message .= '--' . $boundary . '_alt--' . PHP_EOL;

        ini_set('sendmail_from', $this->from);

        mail('', '=?UTF-8?B?' . base64_encode($this->subject) . '?=', $message, $header);
    }
}
