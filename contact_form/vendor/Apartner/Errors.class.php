<?php
namespace Apartner;

/**
 * Powerful Class Errors.
 *
 * @package   Apartner
 * @author    Roman Matviy <roman@matviy.pp.ua>
 * @site      https://roman.matviy.pp.ua
 * @copyright 2022 Roman Matviy <roman@matviy.pp.ua>
 */

class Errors
{
    public static function check($form)
    {
        if (isset($_GET['error'])) {
            $formErr = $_GET['error'];
        } elseif (isset($_GET['send'])) {
            $formErr = $_GET['send'];
        } else {
            $formErr    = 'invalid';
        }

        $text       ='';
        $errMessage = '';

        switch ($formErr) {
            case "errFields_$form":
                $text       = 'Fill all form fields';
                $errMessage = '<p class="callformEr erRed">' . $text . '</p>';
                break;
            case "errName_$form":
                $text       = 'Enter your name';
                $errMessage = '<p class="callformEr erRed">' . $text . '</p>';
                break;
            case "errPhone_$form":
                $text       = 'Enter your phone';
                $errMessage = '<p class="callformEr erRed">' . $text . '</p>';
                break;
            case "errValPhone_$form":
                $text       = 'Not valid phone number';
                $errMessage = '<p class="callformEr erRed">' . $text . '</p>';
                break;
            case "errEmail_$form":
                $text       = 'Enter your email';
                $errMessage = '<p class="callformEr erRed">' . $text . '</p>';
                break;
            case "errValEmail_$form":
                $text       = 'Not valid email address!';
                $errMessage = '<p class="callformEr erRed">' . $text . '</p>';
                break;

            case "errNote_$form":
                $text       = 'Enter your message';
                $errMessage = '<p class="callformEr erRed">' . $text . '</p>';
                break;

            case "errStreetName_$form":
                $text       = 'Enter the street address';
                $errMessage = '<p class="callformEr erRed">' . $text . '</p>';
                break;

            case "errStreetNumber_$form":
                $text       = 'Enter the street number';
                $errMessage = '<p class="callformEr erRed">' . $text . '</p>';
                break;

            case "errZip_$form":
                $text       = 'Not valid zip code!';
                $errMessage = '<p class="callformEr erRed">' . $text . '</p>';
                break;

            case "errValC_$form":
                $text       = 'Not valid';
                $errMessage = '<p class="callformEr erRed">' . $text . '</p>';
                break;

            case "errValSec_$form":
                $text       = 'Security Alert: Unable to process your request.';
                $errMessage = '<p class="callformEr erRed">' . $text . '</p>';
                break;

            case "val_$form":
                $text       = 'Request sent';
                $errMessage = '<p class="callformEr erGreen">' . $text . '</p>';
                break;

            default:
                // $errMessage = '<p class="callformEr erNormal">Send us a message</p>';
                $errMessage = '';
        }

        echo $errMessage;

        if (isset($errMessage)) {
            if (isset($_GET['error'])) {
                $formErr = 'error';
            } elseif (isset($_GET['send'])) {
                $formErr = 'send';
            }

            echo '<script>window.addEventListener("load", function () {
                alert("Form ' . $formErr . '\n' . $text . '");
            });
            </script>';
        }
    }
}
