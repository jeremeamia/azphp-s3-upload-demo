<div class="row">

    <div class="col-md-4 order-md-2">
        <h3 class="mb-3"><span class="text-muted">Details <i class="fas fa-info-circle fa-md"></i></span></h3>
        <p>In <b>Example 4</b>, we do NOT proxy the upload to S3 through our server. Instead we use the
            <code>PostObjectV4</code> object in the AWS SDK for PHP that helps us to create pre-authenticated set of
            form parameters (including a semi-complicated policy) that allows our form to POST directly to S3. Because
            the request is not proxied through our server, it should be faster (especially for larger uploads).</p>
        <p>The <code>PostObjectV4</code> generates extra form fields that must be included in the POST. Click on
            "Toggle showing hidden fields" to view the generated fields.</p>
        <p><b><var>key</var>:</b> This field determines the object's key in S3. The default value is
            <code>${filename}</code>, which means that the name of the uploaded file is used as the key. In our
            example app, we have a separate field for the <code>fileTitle</code> as well as the
            <code>fileCategory</code> that affect what we want the object's key to be, so we use jQuery to update the
            <var>key</var> field's value on the form's "submit" event.</p>
        <p><b><var>file</var></b>: The field name for the actual upload input must be <var>file</var>. Also, it must be
            the last field in the request (strange S3 restriction), so we have to make sure we put the hidden fields
            above it, and that the submit button element does not have a <code>name</code> attribute.</p>
    </div>

    <div class="col-md-8 order-md-1">
        <div class="mb-3">
            <a href="/"><i class="fas fa-angle-left fa-md"></i> Go back</a>
        </div>

        <?php include 'upload.php' ?>
    </div>

</div>
