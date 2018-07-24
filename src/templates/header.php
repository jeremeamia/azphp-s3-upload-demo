<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="/favicon.ico">
    <title>azPHP S3 Upload Demo</title>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css"
          integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B"
          crossorigin="anonymous">
    <link rel="stylesheet"
          href="https://use.fontawesome.com/releases/v5.1.1/css/all.css"
          integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ"
          crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <style>
        .object-list-item .fa-trash-alt {visibility: hidden;}
        .object-list-item:hover .fa-trash-alt {visibility: visible;}
    </style>
</head>

<body class="bg-light">

<div class="container">

    <div class="row">
        <div class="col">
            <div class="py-5 text-center">
                <h1 class="display-3">azPHP S3 Upload Demo</h1>
                <p class="lead">This example application was created to demonstrate how to perform uploads to Amazon S3 from PHP.</p>
            </div>
        </div>
    </div>

    <?php if (!empty($_alerts)): ?>
    <div class="row">
        <div class="col">
            <?php foreach ($_alerts as $alert): ?>
                <div class="alert alert-<?= $alert->type ?> alert-dismissible fade show" role="alert">
                    <strong><?= $alert->title ?></strong>: <?= $alert->message ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

<!-- BEGIN PAGE CONTENT -->
