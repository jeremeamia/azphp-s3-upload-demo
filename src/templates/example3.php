<div class="row">

    <div class="col-md-4 order-md-2">
        <h3 class="mb-3"><span class="text-muted">Details <i class="fas fa-info-circle fa-md"></i></span></h3>
        <p>In <b>Example 3</b>, we proxy the upload to S3 through our server, pulling data from PSR-7
            <code>ServerRequest</code> and passing it to Flysystem (using the S3 adapter).</p>
        <p>To be honest, Flysystem adds very little benefit to this use case. It is a neat abstraction in general though.</p>
    </div>

    <div class="col-md-8 order-md-1">
        <div class="mb-3">
            <a href="/"><i class="fas fa-angle-left fa-md"></i> Go back</a>
        </div>

        <?php include 'upload.php' ?>
    </div>

</div>
