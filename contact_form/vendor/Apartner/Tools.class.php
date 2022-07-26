<?php
namespace Apartner;

class Tools
{
    // codes
    public const CODES =[
        205, 251, 256, 334, 938, 907, 480, 520, 602, 623, 928, 479, 501, 870, 209, 213, 279, 310, 323, 408, 415, 424, 442, 510, 530, 559, 562, 619, 626, 628, 650, 657, 661, 669, 707, 714, 747, 760, 805, 818, 820, 831, 858, 909, 916, 925, 949, 951, 303, 719, 720, 970, 203, 475, 860, 959, 302, 239, 305, 321, 352, 386, 407, 561, 727, 754, 772, 786, 813, 850, 863, 904, 941, 954, 229, 404, 470, 478, 678, 706, 762, 770, 912, 808, 208, 986, 217, 224, 309, 312, 331, 618, 630, 708, 773, 779, 815, 847, 872, 219, 260, 317, 463, 574, 765, 812, 930, 319, 515, 563, 641, 712, 316, 620, 785, 913, 270, 364, 502, 606, 859, 225, 318, 337, 504, 985, 207, 240, 301, 410, 443, 667, 339, 351, 413, 508, 617, 774, 781, 857, 978, 231, 248, 269, 313, 517, 586, 616, 734, 810, 906, 947, 989, 218, 320, 507, 612, 651, 763, 952, 228, 601, 662, 769, 314, 417, 573, 636, 660, 816, 406, 308, 402, 531, 702, 725, 775, 603, 201, 551, 609, 640, 732, 848, 856, 862, 908, 973, 505, 575, 212, 315, 332, 347, 516, 518, 585, 607, 631, 646, 680, 716, 718, 838, 845, 914, 917, 929, 934, 252, 336, 704, 743, 828, 910, 919, 980, 984, 701, 216, 220, 234, 330, 380, 419, 440, 513, 567, 614, 740, 937, 405, 539, 580, 918, 458, 503, 541, 971, 215, 223, 267, 272, 412, 445, 484, 570, 610, 717, 724, 814, 878, 401, 803, 843, 854, 864, 605, 423, 615, 629, 731, 865, 901, 931, 210, 214, 254, 281, 325, 346, 361, 409, 430, 432, 469, 512, 682, 713, 726, 737, 806, 817, 830, 832, 903, 915, 936, 940, 956, 972, 979, 385, 435, 801, 802, 276, 434, 540, 571, 703, 757, 804, 206, 253, 360, 425, 509, 564, 202, 304, 681, 262, 414, 534, 608, 715, 920, 307,
    ];

    //not allowed words
    public const NEEDLES = ['urgency', 'market', 'marketing', 'advertise', 'advertising', 'advertisement', 'token', 'req-name', 'req-email', 'typeOfChange', 'urgency', 'URL-main', 'addURLS', 'curText', 'newText', 'save-stuff', '(', ')', '{', '}', '<', '>', "'", '"', '.', '$', 'dollar', 'dollars', 'dolar', 'dolars', 'price'];

    public static function ipToCountry($ip)
    {
        $numbers = preg_split("/\./", $ip);
        include 'ip_files/' . $numbers[0] . '.php';
        $code=($numbers[0] * 16777216) + ($numbers[1] * 65536) + ($numbers[2] * 256) + ($numbers[3]);
        foreach ($ranges as $key => $value) {
            if ($key <= $code) {
                if ($ranges[$key][0] >= $code) {
                    $country=$ranges[$key][1];
                    break;
                }
            }
        }
        return $country;
    }

    public static function generateFormToken($form)
    {
        $token                      = md5(uniqid(microtime(), true));
        $_SESSION[$form . '_token'] = $token;
        return $token;
    }

    public static function stripCleanToHtml($s)
    {
        //xss clean
        $s = self::xssClean($s);

        // cleaning input for everything which doesn't include any html
        return htmlentities(trim(strip_tags(stripslashes($s))), ENT_NOQUOTES, 'UTF-8');
    }

    //if word from note is in array list
    public static function match($needles = false, $noteS = false)
    {
        if ($needles && $noteS) {
            foreach ($needles as $needle) {
                if (mb_strpos($noteS, $needle) !== false) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function countDigit($number)
    {
        return mb_strlen($number);
    }

    public static function verifyFormToken($form)
    {
        // check if a session is started and a token is transmitted, if not return an error
        if (!isset($_SESSION[$form . '_token'])) {
            return false;
        }

        // check if the form is sent with token in it
        if (!isset($_POST['token'])) {
            return false;
        }

        // compare the tokens against each other if they are still the same
        if ($_SESSION[$form . '_token'] !== $_POST['token']) {
            return false;
        }

        return true;
    }

    public static function writeLog($where)
    {
        $ip   = $_SERVER['REMOTE_ADDR']; // Get the IP from superglobal
        $host = gethostbyaddr($ip);    // Try to locate the host of the attack
        $date = date('d M Y');

        // create a logging message with php heredoc syntax
        $logging = <<<LOG
                    \n
                    << Start of Message >>
                    There was a hacking attempt on your form. \n
                    Date of Attack: {$date}
                    IP-Adress: {$ip} \n
                    Host of Attacker: {$host}
                    Point of Attack: {$where}
                    << End of Message >>
            LOG;

        // open log file
        if ($handle = fopen('formlog.log', 'a')) {
            fputs($handle, $logging);  // write the Data to file
            fclose($handle);
            // close the file
            $to      = 'ewa@webmastersdesktop.com';
            $subject = 'Swift-Services Form attempted';
            $header  = 'From: websitepba@gmail.com';
            mail($to, $subject, $logging, $header);
            $url = '../contact.php';
            header("location: $url");
            exit();
        } else {  // if first method is not working, for example because of wrong file permissions, email the data
            $to      = 'ewa@webmastersdesktop.com';
            $subject = 'Swift-Services Form attempted';
            $header  = 'From: websitepba@gmail.com';
            mail($to, $subject, $logging, $header);
            $url = '../contact.php';
            header("location: $url");
            exit();
        }
    }

    public static function xssClean($data)
    {
        // Fix &entity\n;
        $data = str_replace(['&amp;', '&lt;', '&gt;'], ['&amp;amp;', '&amp;lt;', '&amp;gt;'], $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do {
            // Remove really unwanted tags
            $old_data = $data;
            $data     = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        } while ($old_data !== $data);

        // we are done...
        return $data;
    }
}
