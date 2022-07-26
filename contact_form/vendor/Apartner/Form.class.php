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

        Validation::contactSubmit(self::$root, self::$folder, $id, $csrfResponse, self::$email_to, self::$email_log, self::$email_copy);

        $token = Tools::generateFormToken($id); ?>
<div class="contForm" id="newsf<?= $id?>">
    <div class="contPar"><?= Errors::check($id); ?>
    </div><!-- end contPar -->
    <form class="contactForm" id="<?= $id ?>"
          action="./?<?= $id ?>" method="post">

        <?= $antiCSRF->insertHiddenToken($id); ?>
        <input type="hidden" name="form" value="<?= $id ?>">
        <input type="hidden" name="token_<?= $id ?>"
               value="<?= $token ?>">

        <div class="contactFormWrap">
            <div class="contactFormFirst antispam">
                <input type="text" name="firstname" value="fname"
                       onclick="if (this.defaultValue==this.value) this.value=''"
                       onblur="if (this.value=='') this.value=this.defaultValue" required="">

                <input type="text" name="url" value="url" onclick="if (this.defaultValue==this.value) this.value=''"
                       onblur="if (this.value=='') this.value=this.defaultValue" required="">
            </div>

            <div class="formHalfWrapper">
                <!-- name -->
                <?php
            $name = Tools::stripCleanToHtml($_COOKIE["name_$id"]);
        $name     = $name ? $name : 'name'; ?>
                <div class="contactFormHalf">
                    <input type="text" name="name_<?= $id ?>"
                           value="<?= $name ?>"
                           onclick="if (this.defaultValue==this.value) this.value=''"
                           onblur="if (this.value=='') this.value=this.defaultValue" required="">
                </div><!-- end contactFormHalf -->

                <!-- phone -->
                <?php
            $phone = Tools::stripCleanToHtml($_COOKIE["phone_$id"]);
        $phone     = $phone ? $phone : 'phone'; ?>
                <div class="contactFormHalf">
                    <input type="text" name="phone_<?= $id ?>"
                           value="<?= $phone ?>"
                           onclick="if (this.defaultValue==this.value) this.value=''"
                           onblur="if (this.value=='') this.value=this.defaultValue" required="">
                </div><!-- end contactFormHalf -->

                <!-- email -->
                <?php
            $email = Tools::stripCleanToHtml($_COOKIE["email_$id"]);
        $email     = $email ? $email : 'email'; ?>
                <div class="contactFormHalf">
                    <input type="text" name="email_<?= $id ?>"
                           value="<?= $email ?>"
                           onclick="if (this.defaultValue==this.value) this.value=''"
                           onblur="if (this.value=='') this.value=this.defaultValue" required="">
                </div><!-- end contactFormHalf -->
            </div><!-- end formHalfWrapper -->

            <div class="formHalfWrapper two-columns">
                <!-- street number -->
                <?php
            $street_number = Tools::stripCleanToHtml($_COOKIE["street_number_$id"]);
        $street_number     = $street_number ? $street_number : 'street number'; ?>
                <div class="contactFormHalf">
                    <input type="text"
                           name="street_number_<?= $id ?>"
                           value="<?= $street_number ?>"
                           onclick="if (this.defaultValue==this.value) this.value=''"
                           onblur="if (this.value=='') this.value=this.defaultValue" required="">
                </div><!-- end contactFormHalf -->

                <!-- street name -->
                <?php
            $street_name = Tools::stripCleanToHtml($_COOKIE["street_name_$id"]);
        $street_name     = $street_name ? $street_name : 'street name'; ?>
                <div class="contactFormHalf">
                    <input type="text" name="street_name_<?= $id ?>"
                           value="<?= $street_name ?>"
                           onclick="if (this.defaultValue==this.value) this.value=''"
                           onblur="if (this.value=='') this.value=this.defaultValue" required="">
                </div><!-- end contactFormHalf -->

            </div><!-- end formHalfWrapper -->

            <!-- address -->
            <div class="formHalfWrapper two-columns">
                <!-- city -->
                <?php
            $city = Tools::stripCleanToHtml($_COOKIE["city_$id"]);
        $city     = $city ? $city : 'city'; ?>
                <div class="contactFormHalf">
                    <input type="text" name="city_<?= $id ?>"
                           value="<?= $city ?>"
                           onclick="if (this.defaultValue==this.value) this.value=''"
                           onblur="if (this.value=='') this.value=this.defaultValue" required="">
                </div><!-- end contactFormHalf -->

                <!-- ZIP -->
                <?php
            $zip = Tools::stripCleanToHtml($_COOKIE["zip_$id"]);
        $zip     = $zip ? $zip : 'zip'; ?>
                <div class="contactFormHalf">
                    <input type="text" name="zip_<?= $id ?>"
                           value="<?= $zip ?>"
                           onclick="if (this.defaultValue==this.value) this.value=''"
                           onblur="if (this.value=='') this.value=this.defaultValue" required="">
                </div>
            </div><!-- end formHalfWrapper -->


            <!-- note -->
            <?php
            $note = Tools::stripCleanToHtml($_COOKIE["note_$id"]);
        $note     = $note ? $note : ''; ?>
            <div class="contactFormFull">
                <div class="contactFormHalf">
                    <textarea
                              name="txtArea_<?= $id ?>"><?= $note ?></textarea>
                </div>
            </div><!-- end stoneFormFull -->

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
            echo '<link rel="stylesheet" href="/' . self::$folder . '/public/style.css">';
            // echo '<script type="text/javascript" src="/' . self::$folder . '/public/contact-form.js"></script>';
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
