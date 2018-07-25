<?php if (isset($hiddenFields)): ?>

    <button id="#showFieldsBtn" class="btn btn-secondary btn-sm mb-3" type="button" data-toggle="collapse" data-target="#hiddenFields" aria-expanded="false" aria-controls="hiddenFields">
        <i class="fas fa-eye-slash fa-md"></i> Toggle showing hidden fields
    </button>

    <div id="hiddenFields" class="collapse mb-3">
        <?php foreach (array_chunk($hiddenFields, 2, true) as $group): ?>
            <div class="row">
            <?php foreach ($group as $name => $value): ?>
                <div class="col-md-6 mb-3">
                    <label for="s3_<?= $name ?>"><var><?= $name ?></var></label>
                    <input type="text" class="form-control" id="s3_<?= $name ?>" name="<?= $name ?>" value="<?= $value ?>" readonly>
                </div>
            <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
        <hr class="mb-3">
    </div>

    <script>
        $(function() {
            // Intercept form submission to customize "key" field.
            $('#uploadForm').submit(function() {
                $('#s3_key').val('assets/' + $('#fileCategory').val() + '/' + $('#fileTitle').val());
                return true;
            });
        });
    </script>

<? endif; ?>
