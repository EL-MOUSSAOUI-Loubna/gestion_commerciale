<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . '/header.php'; ?>
    <!-- CSS -->
    <link href="/stage/public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/stage/public/assets/css/all.min.css" rel="stylesheet">
    <link href="/stage/public/assets/css/app.css" rel="stylesheet">
</head>

<body>

    <?php include __DIR__ . '/sidebar.php'; ?>

    <?php include __DIR__ . '/navbar.php'; ?>

    <div class="main-content">
        <div class="container-fluid">
            <?php include VIEW_PATH. '/' . $content_view . '.php'; ?>
        </div>
    </div>

    <?php include __DIR__ . '/b_nav.php'; ?>
    <?php include __DIR__ . '/footer.php'; ?>
</body>

</html>