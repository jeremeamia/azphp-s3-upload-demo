<div class="row">

    <div class="col-md-4 order-md-2">
        <h3 class="mb-3"><span class="text-muted">Details <i class="fas fa-info-circle fa-md"></i></span></h3>
        <p>In <b>Example 4</b>, we do NOT proxy the upload to S3 through our server. Instead we use the
           <code>PostObjectV4</code> object in the AWS SDK for PHP that helps us to create pre-signed form parameters
           that all our form to POST directly to S3.</p>
        <p>Because the request is not proxied through our server, it should end up being faster.</p>
        <p><b>Note:</b> The API for this is pretty complicated. If you are going to do it, I definitely suggest using the SDK.</p>
    </div>

    <div class="col-md-8 order-md-1">
        <div class="mb-3">
            <a href="/"><i class="fas fa-angle-left fa-md"></i> Go back</a>
        </div>

        <?php include 'upload.php' ?>
    </div>

</div>
