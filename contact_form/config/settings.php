<?php

$root          = $_SERVER['DOCUMENT_ROOT'];
$folder        = 'contact_form';
$subject_title = 'Skampa Painting';

require_once $root . '/' . $folder . '/vendor/autoload.php';
require_once $root . '/' . $folder . '/config/functions.php';

$helperLoader = new SplClassLoader('Helpers', $root . '/' . $folder . '/vendor');
$contact      = new  SplClassLoader('Apartner', $root . '/' . $folder . '/vendor');

$helperLoader->register();
$contact->register();

use Helpers\Config;
use Apartner\Tools;
use Apartner\Validation;
use Apartner\SecurityService;
use Apartner\Errors;
use Apartner\Mail;
use Apartner\Form;

$config = new Config;
$config->load($root . '/' . $folder . '/config/config.php');

$email_log   = $config->get('email.log');
$email_to    = $config->get('email.to');
$email_copy  = $config->get('email.copy');

$contact_form = new Form($email_to, $email_log, $email_copy);
