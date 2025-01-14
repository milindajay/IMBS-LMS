<!DOCTYPE html>
<html lang="en" class="h-full bg-white">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">
    <title>IMBS LMS - <?php echo $pageTitle ?? 'IMBS LMS'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Poppins:wght@300&display=swap"
        rel="stylesheet">
    <style>
    .heading {
        font-family: 'Montserrat', sans-serif;
    }

    .text {
        font-family: 'Poppins', sans-serif;
    }
    </style>
    <?php if(isset($criticalCSS)): ?>
    <style>
    <?php echo $criticalCSS;
    ?>
    </style>
    <?php endif; ?>
</head>

<body class="bg-gray-100 flex flex-col h-full">