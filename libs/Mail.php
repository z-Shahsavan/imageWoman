<?php

//sender('sender@mail....');
//addTo('target email');
//subject('subject');
//html('HTML Template', false); false=no appaned True=Append
//send();
class Mail {

    static $sender = null;
    static $to = array();
    static $cc = array();
    static $bcc = array();
    static $subject = null;
    static $text = null;
    static $html = null;

    public static function addTo($mail, $name = null) {
        if ($name === null) {
            self:: $to[] = $mail;
        } else {
            self::$to[] = array('name' => $name, 'mail' => $mail);
        }
    }

    public static function addCc($mail, $name = null) {
        if ($name === null) {
            self::$cc[] = $mail;
        } else {
            self::$cc[] = array('name' => $name, 'mail' => $mail);
        }
    }

    public static function addBcc($mail, $name = null) {
        if ($name === null) {
            self::$bcc[] = $mail;
        } else {
            self::$bcc[] = array('name' => $name, 'mail' => $mail);
        }
    }

    public static function subject($subject = null) {
        if ($subject !== null) {
            self:: $subject = $subject;
        }
        return self::$subject;
    }

    public static function sender($mail, $name = null) {
        if ($name === null) {
            self::$sender = $mail;
        } else {
            self::$sender = array('name' => $name, 'mail' => $mail);
        }
    }

    public static function text($text, $append = false) {
        if ($append === false || self::$text === null) {
            self:: $text = $text;
        } else {
            self::$text .= $text;
        }
    }

    public static function html($html, $append = false) {
        if ($append === false || self::$html === null) {
            self::$html = $html;
        } else {
            self::$html .= $html;
        }
    }

    public static function send() {
        $headers = '';
        $body = '';

        $cto = count(self::$to);
        $ccc = count(self::$cc);
        $cbcc = count(self::$bcc);

        if ($cto < 1 && $ccc < 1 && $cbcc < 1) {
            throw new Exception('Trying to send an e-mail without recipients');
        }

        if (self::$text === null && self::$html === null) {
            throw new Exception('Trying to send an e-mail without body');
        } else if (self::$text !== null && self::$html === null) {
            $body = self::$text;
        } else if (self::$text === null && self::$html !== null) {
            $headers .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $body = self::$html;
        } else {
            $boundary = md5(microtime(true));
            $headers .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-Type: multipart/alternative; boundary="' . $boundary . '"' . "\r\n";
            $headers .= 'Content-Transfer-Encoding: 7bit' . "\r\n";

            $body .= '--' . $boundary . "\n";
            $body .= 'Content-Type: text/plain; charset=utf-8' . "\n";
            $body .= 'Content-Transfer-Encoding: 7bit' . "\n\n";
            $body .= self::$text;
            $body .= "\n\n";

            $body .= '--' . $boundary . "\n";
            $body .= 'Content-Type: text/html; charset=utf-8' . "\n";
            $body .= 'Content-Transfer-Encoding: 7bit' . "\n\n";
            $body .= self::$html;
            $body .= "\n\n";

            $body .= '--' . $boundary . "\n";
        }

        $to = array();
        $cc = array();
        $bcc = array();

        if ($cto > 0) {
            foreach (self::$to as $user) {
                if (is_array($user)) {
                    $to[] = $user['name'] . '<' . $user['mail'] . '>';
                } else {
                    $to[] = $user;
                }
            }
            $to = implode(',', $to);
        }


        if ($ccc > 0) {
            foreach (self::$cc as $user) {
                if (is_array($user)) {
                    $cc[] = $user['name'] . '<' . $user['mail'] . '>';
                } else {
                    $cc[] = $user;
                }
            }
            $cc = implode(',', $cc);
            $headers .= 'CC: ' . $cc . "\r\n";
        }

        if ($cbcc > 0) {
            foreach (self::$bcc as $user) {
                if (is_array($user)) {
                    $bcc[] = $user['name'] . '<' . $user['mail'] . '>';
                } else {
                    $bcc[] = $user;
                }
            }
            $bcc = implode(',', $bcc);
            $headers .= 'Bcc: ' . $bcc . "\r\n";
        }

        if (self::$sender !== null) {
            if (is_array(self::$sender)) {
                $headers .= 'From: ' . self::$sender['name'] . ' <' . self::$sender['mail'] . '>' . "\r\n";
            } else {
                $headers .= 'From: ' . self::$sender . "\r\n";
            }
        }

        if (self::$subject !== null) {
            $subject = self::$subject;
        }

        return mail($to, $subject, $body, $headers);
    }

}
