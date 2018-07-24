<?php if (isset($hiddenFields)): ?>

    <?php foreach ($hiddenFields as $name => $value): ?>
        <input type="hidden" id="s3_<?= $name ?>" name="<?= $name ?>" value="<?= $value ?>">
    <?php endforeach; ?>

    <script>
        $(function() {
            $('#uploadForm').submit(function() {
                $('#s3_key').val('assets/' + $('#fileCategory').val() + '/' + $('#fileTitle').val());
                return true;
            });
        });
    </script>

<? endif; ?>
