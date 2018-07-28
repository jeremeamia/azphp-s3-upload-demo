<div class="row">

    <div class="col-md-4 order-md-2">
        <h3 class="mb-3"><span class="text-muted">Details <i class="fas fa-info-circle fa-md"></i></span></h3>
        <p>In <b>Example 5</b>, we do the same as example 4 but instead of generating the S3 <code>PostObjectV4</code>
            upfront as hidden fields, we generate them just-in-time (JIT). Right before we submit the form, we use
            JavaScript to prevent the form submission and call our backend with the details from our form to generate
            the <code>PostObjectV4</code>. This data gets returned back to us, and we use it to generate and submit
            a new form with all of the required data.</p>
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
                let upload = document.getElementById('fileUpload').files[0];
                let uploadParams = new URLSearchParams(form.serialize());
                uploadParams.append('fileType', upload.type);
                uploadParams.append('fileSize', upload.size);
                fetch(new Request('/example5', {
                    method: 'POST',
                    body: new URLSearchParams(uploadParams)
                })).then(function (response) {
                    return response.json();
                }).then(function (data) {
                    // Create a new form from the S3 PostObjectV4 data returned to us.
                    let newForm = document.createElement("form");
                    let formAttributes = data['form']['attributes'];
                    newForm.id = 'newUploadForm';
                    newForm.method = formAttributes['method'];
                    newForm.action = formAttributes['action'];
                    newForm.enctype = formAttributes['enctype'];
                    let formInputs = data['form']['inputs'];
                    Object.keys(formInputs).forEach(function (name) {
                        let input = document.createElement("input");
                        input.name = name;
                        input.value = formInputs[name];
                        newForm.appendChild(input);
                    });
                    let inputFile = document.getElementById('fileUpload');
                    newForm.appendChild(inputFile);
                    document.body.appendChild(newForm);
                    newForm.submit();
                });
            });
        });
    </script>

</div>
