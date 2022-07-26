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

        $errMessage = '';

        switch ($formErr) {
            case "errFields_$form":
                $errMessage = '<p class="callformEr erRed">Fill all form fields</p>';
                break;
            case "errName_$form":
                $errMessage = '<p class="callformEr erRed">Enter your name</p>';
                break;
            case "errPhone_$form":
                $errMessage = '<p class="callformEr erRed">Enter your phone</p>';
                break;
            case "errValPhone_$form":
                $errMessage = '<p class="callformEr erRed">Not valid phone number</p>';
                break;
            case "errEmail_$form":
                $errMessage = '<p class="callformEr erRed">Enter your email</p>';
                break;
            case "errValEmail_$form":
                $errMessage = '<p class="callformEr erRed">Not valid email address!</p>';
                break;

            case "errNote_$form":
                $errMessage = '<p class="callformEr erRed">Enter your message</p>';
                break;

            case "errStreetName_$form":
                $errMessage = '<p class="callformEr erRed">Enter the street address</p>';
                break;

            case "errStreetNumber_$form":
                $errMessage = '<p class="callformEr erRed">Enter the street number</p>';
                break;

            case "errZip_$form":
                $errMessage = '<p class="callformEr erRed">Not valid zip code!</p>';
                break;

            case "errValC_$form":
                $errMessage = '<p class="callformEr erRed">Not valid</p>';
                break;

            case "errValSec_$form":
                $errMessage = '<p class="callformEr erRed">Security Alert: Unable to process your request.</p>';
                break;

            case "val_$form":
                $errMessage = '<p class="callformEr erGreen">Request sent</p>';
                break;

            default:
                $errMessage = '<p class="callformEr erNormal">Send us a message</p>';
        }

        echo $errMessage;
    }
}
