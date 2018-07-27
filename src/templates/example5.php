<div class="row">

    <div class="col-md-4 order-md-2">
        <h3 class="mb-3"><span class="text-muted">Details <i class="fas fa-info-circle fa-md"></i></span></h3>
        <p>In <b>Example 5</b>, we attempt to do an upload to S3's PUT endpoint using a pre-signed request.</p>
    </div>

    <div class="col-md-8 order-md-1">
        <div class="mb-3">
            <a href="/"><i class="fas fa-angle-left fa-md"></i> Go back</a>
        </div>

        <?php include 'upload.php' ?>
    </div>

    <script>
        $(function() {
            let form = $('#uploadForm');
            form.submit(function(e) {
                e.preventDefault();
                fetch(new Request('/example5', {
                    method: 'POST',
                    body: new URLSearchParams(form.serialize())
                })).then(function (response) {
                    return response.json();
                }).then(function (data) {
                    return fetch(new Request(data['s3put'], {
                        method: 'PUT',
                        body: document.getElementById('fileUpload').files[0],
                        mode: "cors"
                    }));
                }).then(function (response) {
                    return response.text();
                }).then(function (text) {
                    console.log(text);
                });
            });
        });
    </script>

</div>
