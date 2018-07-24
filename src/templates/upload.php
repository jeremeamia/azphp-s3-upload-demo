<form class="needs-validation" action="<?= $action ?>" method="post" enctype="multipart/form-data">

    <h3 class="mb-3">Upload to S3</h3>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="fileName">File Name</label>
            <input type="text" class="form-control" id="fileName" name="fileName" required>
            <div class="invalid-feedback">Valid file name is required.</div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="fileCategory">Category</label>
            <select class="custom-select d-block w-100" id="fileCategory" name="fileCategory" required>
                <option value="">Choose...</option>
                <option value="images">Images</option>
                <option value="scripts">Scripts</option>
                <option value="stylesheets">Stylesheets</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="fileUpload" name="fileUpload" required>
                <label class="custom-file-label" for="fileUpload">Choose file</label>
            </div>
        </div>
    </div>

    <button class="btn btn-primary btn-lg btn-block" type="submit">Upload the file</button>
</form>
