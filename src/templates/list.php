<div class="row">

    <div class="col-md-4 order-md-2">
        <h3 class="mb-3"><span class="text-muted">Details <i class="fas fa-info-circle fa-md"></i></span></h3>
        <p>The list on this page is a list of all the object keys in the bucket.</p>
        <p>For the sake of the demo, there is a delete button on each key if you need to remove it.</p>
        <p><b>Note:</b> It's not a good idea to list large buckets without pagination.</p>
    </div>

    <div class="col-md-8 order-md-1">
        <div class="mb-3">
            <a href="/"><i class="fas fa-angle-left fa-md"></i> Go back</a>
        </div>

        <h3 class="mb-3">Objects in <code><?= $bucket ?></code></h3>
        <ul class="list-group mb-5">
            <?php foreach ($objects as $key): ?>
                <li class="list-group-item">
                    <?= $key ?>
                    <div class="float-right">
                        <a href="/delete-object?<?= http_build_query(compact('key')) ?>"><i class="fas fa-trash-alt fa-lg"></i></a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</div>
