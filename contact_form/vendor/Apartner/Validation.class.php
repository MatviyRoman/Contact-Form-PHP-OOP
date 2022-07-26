<?php
namespace Apartner;

use Helpers\Config;

/**
 * Powerful Class Validation.
 *
 * @package   Apartner
 * @author    Roman Matviy <roman@matviy.pp.ua>
 * @site      https://roman.matviy.pp.ua
 * @copyright 2022 Roman Matviy <roman@matviy.pp.ua>
 */

class Validation
{
    private static function redirect($url, $form)
    {
        // header("location: $url");
        echo '<script type="text/javascript">
            window.location.href = "' . $url . $form . '";
        </script>';
    }

    public static function contactSubmit($form, $csrfResponse, $email_to, $email_log, $email_copy)
    {
        $subject_title = $GLOBALS['subject_title'];

        //!  process form

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $form = ($_POST['form']);
            $url  = $_SERVER['SCRIPT_NAME'];

            $name   = Tools::stripCleanToHtml($_POST["name_$form"]);
            $phone  = Tools::stripCleanToHtml($_POST["phone_$form"]);
            $email  = Tools::stripCleanToHtml($_POST["email_$form"]);
            $note   = Tools::stripCleanToHtml($_POST["txtArea_$form"]);
            $noteS  = mb_strtolower($note);

            $street_name     = Tools::stripCleanToHtml($_POST["street_name_$form"]);
            $street_number   = Tools::stripCleanToHtml($_POST["street_number_$form"]);
            $city            = Tools::stripCleanToHtml($_POST["city_$form"]);
            $zip             = Tools::stripCleanToHtml($_POST["zip_$form"]);

            //! fields for antispam
            $fname        = Tools::stripCleanToHtml($_POST['fname']);
            $field_url    = Tools::stripCleanToHtml($_POST['url']);

            $token        = Tools::stripCleanToHtml($_POST["token_$form"]);
            $cookie_token = $_COOKIE["token_$form"]; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js"
        integrity="sha512-wT7uPE7tOP6w4o28u1DN775jYjHQApdBnib5Pho4RB0Pgd9y7eSkAV1BTqQydupYDB9GBhTcQQzyNMPMV3cAew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    Cookies.get('token_<?= $form ?>');
    Cookies.set('name_<?= $form ?>',
        '<?= $name ?>');
    Cookies.set('phone_<?= $form ?>',
        '<?= $phone ?>');
    Cookies.set('email_<?= $form ?>',
        '<?= $email ?>');
    Cookies.set('city_<?= $form ?>',
        '<?= $city ?>');
    Cookies.set('street_name_<?= $form ?>',
        '<?= $street_name ?>');
    Cookies.set('street_number_<?= $form ?>',
        '<?= $street_number ?>');
    Cookies.set('zip_<?= $form ?>',
        '<?= $zip ?>');
    Cookies.set('note_<?= $form ?>',
        '<?= $noteS ?>');
</script>
<?php

            //! error cookie
            if ($cookie_token != $token) {
                $url .= '?error=errValSec_' . $form . '#newsf';
                self::redirect($url, $form);
                exit();
            }

            //! SecurityService
            if (empty($csrfResponse)) {
                $url .= '?error=errValSec_"' . $form . '#newsf';
                self::redirect($url, $form);
                exit();
            }

            echo '<script>Cookies.remove("token_' . $form . '")</script>';
            echo '<script>Cookies.remove("name_' . $form . '")</script>';
            echo '<script>Cookies.remove("phone_' . $form . '")</script>';
            echo '<script>Cookies.remove("email_' . $form . '")</script>';
            echo '<script>Cookies.remove("city_' . $form . '")</script>';
            echo '<script>Cookies.remove("zip_' . $form . '")</script>';
            echo '<script>Cookies.remove("street_name_' . $form . '")</script>';
            echo '<script>Cookies.remove("street_number_' . $form . '")</script>';
            echo '<script>Cookies.remove("note_' . $form . '")</script>';

            if ($fname != '' && $fname != 'fname' || isset($field_url) && $field_url != 'url') {
                $url .= '?';

                self::redirect($url, $form);
                exit();
            } else {
                if ($name == 'name' && $phone == 'phone' && $email == 'email' && !$note && $street_name == 'street name' && $street_number == 'street number' && $city == 'city' && $zip == 'zip') {
                    $url .= '?error=errFields_' . $form . '#newsf';

                    self::redirect($url, $form);
                    exit();
                }

                if (Tools::match(Tools::NEEDLES, $noteS)) {
                    $url .= '?';
                    self::redirect($url, $form);
                    exit();
                } else {
                    //! validate form fields

                    //! validate phone
                    $phoneS        = preg_replace('/[^0-9]/', '', $phone);
                    $number_digits = Tools::countDigit($phoneS);
                    $first_digit   = mb_substr($phoneS, 0, 1);
                    $get_code      = mb_substr($phoneS, 0, 3);

                    if ($first_digit == 1) {
                        $get_code   = mb_substr($phoneS, 1, 3);
                    }

                    if ((($number_digits == 11)) && ($first_digit != '1') && (\in_array($get_code, Tools::CODES)) || ($number_digits == 10) && (\in_array($get_code, Tools::CODES))) {
                        // $to       = 'ewa@webmastersdesktop.com';
                        $to       = $email_log;
                        $subject  = $subject_title . ' Form Wrong Number';
                        $headers  = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= "Bcc: $email_copy\r\n";
                        $message = "Wrong number is: $phone ";
                        mail($to, $subject, $message, $headers);

                        $url .= '?';

                        self::redirect($url, $form);
                        exit();
                    } else {
                        if (empty($name) || ($name == 'name')) {
                            // $url =  '../contact.php?error=errName#newsf';
                            $url .= '?error=errName_' . $form . '#newsf';

                            self::redirect($url, $form);
                            exit();
                        }

                        if (empty($phone) || ($phone == 'phone')) {
                            // $url =  '../contact.php?error=errPhone#newsf';
                            $url .= '?error=errPhone_' . $form . '#newsf';

                            self::redirect($url, $form);
                            exit();
                        } elseif (array_search($get_code, Tools::CODES) == false && $number_digits == 11 && $first_digit == '1' || array_search($get_code, Tools::CODES) == false && $number_digits == 10) {
                            // $to       = 'ewa@webmastersdesktop.com';
                            $to       = $email_log;
                            $subject  = $subject_title . ' Form Wrong Number';
                            $headers  = 'MIME-Version: 1.0' . "\r\n";
                            $headers .= "Bcc: $email_copy\r\n";
                            $message = "Wrong number is: $phone ";
                            mail($to, $subject, $message, $headers);

                            $mail = new Mail();
                            $mail->setTo($to);
                            $mail->setFrom($email);
                            $mail->setSenderEmail($email);
                            $mail->setSender($name);
                            $mail->setHtml($message);
                            $mail->setSubject($subject_title);
                            $mail->send();

                            // $url =  '../contact.php?error=errPhone#newsf';
                            $url .= '?error=errValPhone_' . $form . '#newsf';

                            self::redirect($url, $form);
                            exit();
                        } else {
                            if ((!preg_match('/^[0-9]{10}$/', $phoneS)) && (!preg_match('/^[0-9]{7}$/', $phoneS)) && (!preg_match('/^[0-9]{11}$/', $phoneS))) {
                                // $url =  '../contact.php?error=errValPhone#newsf';
                                $url .= '?error=errValPhone_' . $form . '#newsf';

                                self::redirect($url, $form);
                                exit();
                            }
                        }

                        //! validate email
                        if (empty($email) || ($email == 'email')) {
                            // $url =  '../contact.php?error=errEmail#newsf';
                            $url .= '?error=errEmail_' . $form . '#newsf';

                            self::redirect($url, $form);
                            exit();
                        } else {
                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                // $url =  '../contact.php?error=errValEmail#newsf';
                                $url .= '?error=errValEmail_' . $form . '#newsf';

                                self::redirect($url, $form);
                                exit();
                            }
                        }

                        //! validate note

                        if ($note == '') {
                            // $url =  '../contact.php?error=errNote#newsf';
                            $url .= '?error=errNote_' . $form . '#newsf';

                            self::redirect($url, $form);
                            exit();
                        }

                        $zip             = Tools::stripCleanToHtml($_POST["zip_$form"]);

                        //! validate street name
                        if (empty($street_name) || ($street_name == 'street name')) {
                            $url .= '?error=errStreetName_' . $form . '#newsf';

                            self::redirect($url, $form);
                            exit();
                        }

                        //! validate street number
                        if (empty($street_number) || ($street_number == 'street number') || \is_int($street_number)) {
                            $url .= '?error=errStreetNumber_' . $form . '#newsf';

                            self::redirect($url, $form);
                            exit();
                        }

                        //! validate city
                        if (empty($city) || ($city == 'city')) {
                            $url .= '?error=errCity_' . $form . '#newsf';

                            self::redirect($url, $form);
                            exit();
                        }

                        //! validate zip
                        if (empty($zip) || ($zip == 'zip') || \is_int($zip)) {
                            $url .= '?error=errZip_' . $form . '#newsf';

                            self::redirect($url, $form);
                            exit();
                        }

                        //! email data

                        date_default_timezone_set('America/New_York');
                        $date = date('F j, Y, g:i a');

                        $message = "Date: $date <br><br><hr>";
                        $message .= "Name: $name <br>";
                        $message .= "Email: $email <br>";
                        $message .= "Phone: $phone <br>";
                        $message .= "Street number: $street_number <br>";
                        $message .= "Street name: $street_name <br>";
                        $message .= "City: $city <br>";
                        $message .= "Zip: $zip <br>";
                        $message .= "Message: $note <br>";

                        $to = $email_to;
                        //$to = 'ewa@webmastersdesktop.com';
                        $subject  = $subject_title . ' Contact Form Request';
                        $headers  = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                        $headers .= "Bcc: $email_copy,$email_log\r\n";

                        $headers .= 'From:   <' . $email . ">\r\n";

                        mail($to, $subject, $message, $headers);

                        // $mail = new Mail();
                        // $mail->setTo($to);
                        // $mail->setFrom($email);
                        // $mail->setSenderEmail($email);
                        // $mail->setSender($name);
                        // $mail->setHtml($message);
                        // $mail->setSubject($subject_title);
                        // $mail->send();

                        $url .= '?send=val_' . $form . '#newsf';

                        self::redirect($url, $form);
                        exit();
                    } //! end note validated
                } //! end digit validation
            } //! end first name validated
        }
    }
}
