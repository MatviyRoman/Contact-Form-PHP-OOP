<!DOCTYPE html>
<html>

<head>
    <title>Contact Form</title>
</head>

<body>
    <?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/contact_form/config/settings.php';

$contact_form->buttonText('Submit');
$contact_form->render('contactForm');

?>
</body>

</html>