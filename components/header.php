<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'IMBS Campus'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <?php if(isset($useJQuery)): ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php endif; ?>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght=600&family=Poppins:wght=300&display=swap"
        rel="stylesheet">
    <style>
    .heading {
        font-family: 'Montserrat', sans-serif;
    }

    .text {
        font-family: 'Poppins', sans-serif;
    }
    </style>
</head>

<body class="bg-gray-100">