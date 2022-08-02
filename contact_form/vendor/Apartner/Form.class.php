<?php
namespace Apartner;

use Helpers\Config;

/**
 * Powerful Class Form.
 *
 * @package   Apartner
 * @author    Roman Matviy <roman@matviy.pp.ua>
 * @site      https://roman.matviy.pp.ua
 * @copyright 2022 Roman Matviy <roman@matviy.pp.ua>
 */

class Form
{
    public static $count = 0;
    public $buttonText   = 'Submit';
    public static $root;
    public static $folder;
    public static $email_to    = 'skampapainting@gmail.com';
    public static $email_log   = 'ewa@webmastersdesktop.com';
    public static $email_copy  = 'remik@webmastersdesktop.com';

    public function __construct($email_to = null, $email_log = null, $email_copy = null)
    {
        self::$root      = $GLOBALS['root'];
        self::$folder    = $GLOBALS['folder'];
        ++self::$count;

        self::$email_to   = $email_to;
        self::$email_log  = $email_log;
        self::$email_copy = $email_copy;
    }

    public function buttonText($text = null)
    {
        $this->buttonText = $text;
    }

    public function render($id = 'contact')
    {
        $antiCSRF     = new SecurityService();
        $csrfResponse = $antiCSRF->validate($id);

        // Validation::contactSubmit(self::$root, self::$folder, $id, $csrfResponse, self::$email_to, self::$email_log, self::$email_copy);
        Validation::contactSubmit($id, $csrfResponse, self::$email_to, self::$email_log, self::$email_copy);

        $token = Tools::generateFormToken($id); ?>
<div class="contForm" id="newsf<?= $id?>">
    <div class="contPar">
        <p class="callformEr erNormal">Send us a message</p>
    </div><!-- end contPar -->
    <form class="contactForm" id="<?= $id ?>"
          action="?<?= $id ?>" method="post">

        <?= $antiCSRF->insertHiddenToken($id); ?>
        <input type="hidden" name="form" value="<?= $id ?>">
        <input type="hidden" name="token_<?= $id ?>"
               value="<?= $token ?>">

        <div class="contactFormWrap">
            <div class="contactFormFirst antispam">
                <input type="text" name="fname" value="fname"
                       onclick="if (this.defaultValue==this.value) this.value=''"
                       onblur="if (this.value=='') this.value=this.defaultValue" required="">

                <input type="text" name="url" value="url" onclick="if (this.defaultValue==this.value) this.value=''"
                       onblur="if (this.value=='') this.value=this.defaultValue" required="">
            </div>

            <div class="formHalfWrapper">
                <!-- name -->
                <?php

                $name = '';
        if (isset($_COOKIE["name_$id"])) {
            $name = Tools::stripCleanToHtml($_COOKIE["name_$id"]);
        }

        $name     = $name ? $name : 'name'; ?>
                <div class="contactFormHalf">
                    <input type="text" placeholder="name"
                           name="name_<?= $id ?>"
                           value="<?= $name ?>"
                           onclick="if (this.defaultValue==this.value) this.value=''"
                           onblur="if (this.value=='') this.value=this.defaultValue" required="">
                </div><!-- end contactFormHalf -->

                <!-- phone -->
                <?php

        $phone = '';
        if (isset($_COOKIE["phone_$id"])) {
            $phone = Tools::stripCleanToHtml($_COOKIE["phone_$id"]);
        }

        $phone     = $phone ? $phone : 'phone'; ?>
                <div class="contactFormHalf">
                    <input type="text" placeholder="phone"
                           name="phone_<?= $id ?>"
                           value="<?= $phone ?>"
                           onclick="if (this.defaultValue==this.value) this.value=''"
                           onblur="if (this.value=='') this.value=this.defaultValue" required="">
                </div><!-- end contactFormHalf -->

                <!-- email -->
                <?php

            $email = '';
        if (isset($_COOKIE["email_$id"])) {
            $email = Tools::stripCleanToHtml($_COOKIE["email_$id"]);
        }

        $email     = $email ? $email : 'email'; ?>
                <div class="contactFormHalf">
                    <input type="text" placeholder="email"
                           name="email_<?= $id ?>"
                           value="<?= $email ?>"
                           onclick="if (this.defaultValue==this.value) this.value=''"
                           onblur="if (this.value=='') this.value=this.defaultValue" required="">
                </div><!-- end contactFormHalf -->
            </div><!-- end formHalfWrapper -->

            <div class="formHalfWrapper two-columns">
                <!-- street number -->
                <?php

        $street_number = '';
        if (isset($_COOKIE["street_number_$id"])) {
            $street_number = Tools::stripCleanToHtml($_COOKIE["street_number_$id"]);
        }

        $street_number     = $street_number ? $street_number : 'street number'; ?>
                <div class="contactFormHalf">
                    <input type="text" placeholder="street number"
                           name="street_number_<?= $id ?>"
                           value="<?= $street_number ?>"
                           onclick="if (this.defaultValue==this.value) this.value=''"
                           onblur="if (this.value=='') this.value=this.defaultValue" required="">
                </div><!-- end contactFormHalf -->

                <!-- street name -->
                <?php

        $street_name = '';
        if (isset($_COOKIE["street_name_$id"])) {
            $street_name = Tools::stripCleanToHtml($_COOKIE["street_name_$id"]);
        }

        $street_name     = $street_name ? $street_name : 'street name'; ?>
                <div class="contactFormHalf">
                    <input type="text" placeholder="street name"
                           name="street_name_<?= $id ?>"
                           value="<?= $street_name ?>"
                           onclick="if (this.defaultValue==this.value) this.value=''"
                           onblur="if (this.value=='') this.value=this.defaultValue" required="">
                </div><!-- end contactFormHalf -->

            </div><!-- end formHalfWrapper -->

            <!-- address -->
            <div class="formHalfWrapper two-columns">
                <!-- city -->
                <?php

        $city = '';
        if (isset($_COOKIE["city_$id"])) {
            $city = Tools::stripCleanToHtml($_COOKIE["city_$id"]);
        }

        $city     = $city ? $city : 'city'; ?>
                <div class="contactFormHalf">
                    <input type="text" placeholder="city"
                           name="city_<?= $id ?>"
                           value="<?= $city ?>"
                           onclick="if (this.defaultValue==this.value) this.value=''"
                           onblur="if (this.value=='') this.value=this.defaultValue" required="">
                </div><!-- end contactFormHalf -->

                <!-- ZIP -->
                <?php

        $zip = '';
        if (isset($_COOKIE["zip_$id"])) {
            $zip = Tools::stripCleanToHtml($_COOKIE["zip_$id"]);
        }

        $zip     = $zip ? $zip : 'zip'; ?>
                <div class="contactFormHalf">
                    <input type="text" placeholder="zip"
                           name="zip_<?= $id ?>"
                           value="<?= $zip ?>"
                           onclick="if (this.defaultValue==this.value) this.value=''"
                           onblur="if (this.value=='') this.value=this.defaultValue" required="">
                </div>
            </div><!-- end formHalfWrapper -->


            <!-- note -->
            <?php

        $note = '';
        if (isset($_COOKIE["note_$id"])) {
            $note = Tools::stripCleanToHtml($_COOKIE["note_$id"]);
        }

        $note     = $note ? $note : ''; ?>
            <div class="contactFormFull">
                <div class="contactFormHalf">
                    <textarea
                              name="txtArea_<?= $id ?>"><?= $note ?></textarea>
                </div>
            </div><!-- end stoneFormFull -->

            <div class="contPar">
                <?= Errors::check($id); ?>
            </div>
            <!-- end contPar -->

            <div class="contactFormFull">
                <input data-callback="onSubmit" type="submit"
                       name="submit_<?= $id ?>"
                       value="<?= $this->buttonText ?>">

            </div><!-- end contactFormFull -->
        </div><!-- end contactFormWrap -->
    </form>
</div><!-- end contForm -->
<?php
        if (self::$count == 1) {
            echo '<link rel="stylesheet" href="/' . self::$folder . '/assets/style.css">';
            // echo '<script type="text/javascript" src="/' . self::$folder . '/public/contact-form.js"></script>';

            echo '<style>

            .antispam {
                height: 0;
                overflow: hidden;
            }

            .contactFormHalf {
                width: 32%;
                overflow: hidden;
                padding: 20px 0;
              }
              
              .contactFormFirst input[type=text] {
                margin: 0 auto;
                border: 1px solid #fff;
                border-radius: 3px;
                color: #fff;
                padding: 1px;
                display: block;
                width: 100%;
                height: 5px;
                font-size: 14px;
                outline: none;
              }
              
              .contactFormHalf input[type=text],
              .contactFormHalf input[type=number] {
                margin: 10px auto;
                border: 1px solid #ccc;
                border-radius: 3px;
                color: #777;
                padding: 8px 8px 8px 20px;
                display: block;
                width: 100%;
                height: 90px;
                font-size: 24px;
                outline: none;
              }
              
              .contactFormFull {
                width: 100%;
                margin: 0 auto;
                overflow: hidden;
              }
              .contactFormFull .contactFormHalf {
                width: 100%;
              }
              .contactFormFull textarea {
                margin: 10px auto;
                border: none;
                padding: 8px;
                display: block;
                width: 100%;
                height: 160px;
                font-size: 24px;
                border: 1px solid #ccc;
                border-radius: 3px;
                outline: none;
                color: #777;
                resize: none;
              }
              .contactFormFull input[type=submit] {
                border: 1px solid #0099dd;
                background: #0099dd;
                color: #fff;
                display: block;
                cursor: pointer;
                font-size: 21px;
                padding: 10px 40px;
                text-decoration: none;
                min-width: 200px;
                height: 50px;
                margin: 10px auto;
                outline: none;
                text-transform: uppercase;
              }
              .contactFormFull input[type=submit]:hover {
                background: #2a2f30;
                border: 1px solid #2a2f30;
                color: #fff;
              }
              
              .formHalfWrapper.two-columns .contactFormHalf {
                width: 49%;
              }

              @media (max-width: 1023px) {
                .contactForm .contactFormHalf {
                    width: 100% !important;
              }

              @media only screen and (max-width: 767px) {
              .contactFormHalf {
                  width: 100% !important;
                  display: block !important;
                  padding: 5px 0 !important;
              }
            }
              
              @media only screen and (max-width: 767px) {
              .contactFormHalf input[type="text"], .contactFormFull input[type="submit"] {
                  height: 50px !important;
                  font-size: 18px !important;
              }
            }
              
              @media only screen and (max-width: 767px) {
              .contactFormHalf input[type="text"] {
                  font-size: 16px !important;
              }
            }

              </style>';
        }

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js"
            integrity="sha512-wT7uPE7tOP6w4o28u1DN775jYjHQApdBnib5Pho4RB0Pgd9y7eSkAV1BTqQydupYDB9GBhTcQQzyNMPMV3cAew=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>';
            echo '<script>Cookies.set("token_' . $id . '", "' . $token . '")</script>';
        }

        // echo "<script type=\"text/javascript\">document.addEventListener('DOMContentLoaded', function() {
        //     new ContactForm('$id');
        // }, false);
        // </script>";
    }
}
