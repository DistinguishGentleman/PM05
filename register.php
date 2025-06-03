<?php require __DIR__ . '/imports/init.php' ?>
<?php if (!$user->isGuest) {
    $resp->redirect('index.php', []);
    die();
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include __DIR__ . '/imports/head.php' ?>
    <?php include __DIR__ . '/imports/carousel.php' ?>
    <?php include __DIR__ . '/imports/date-timepicker.php' ?>
</head>

<body>
    <?php include __DIR__ . '/imports/init/init_register.php' ?>
    <?php include __DIR__ . '/imports/loader.php' ?>
    <?php include __DIR__ . '/imports/scripts.php' ?>
    <?php include __DIR__ . '/imports/class_script.php' ?>
</body>

</html>