<?php
// require_once __DIR__ . '/../vendor/autoload.php' ; // Автозавантаження файлів за допомогою автозавантаження
//   // Composer використовувати
//   use Apartner\ContactForm;

//   echo ContactForm::world() ;

echo __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload
use HelloWorld\SayHello;

echo HelloWord\SayHello::world();
