<div class="row">

    <div class="col-md-4 order-md-2">
        <h3 class="mb-3"><span class="text-muted">Details <i class="fas fa-info-circle fa-md"></i></span></h3>
        <p>In <b>Example 1</b>, we proxy the upload to S3 through our server, pulling data from <code>$_FILES</code> and
            <code>$_POST</code> and passing them to the AWS SDK for PHP.</p>
    </div>

    <div class="col-md-8 order-md-1">
        <div class="mb-3">
            <a href="/"><i class="fas fa-angle-left fa-md"></i> Go back</a>
        </div>

        <?php include 'upload.php' ?>
    </div>

</div>
