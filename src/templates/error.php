<div class="row">

    <div class="col-md-12">
        <div class="mb-3">
            <a href="/"><i class="fas fa-angle-left fa-md"></i> Go back</a>
        </div>

        <h3 class="mb-3">Error</h3>
        <p class="lead"><i class="fas fa-exclamation-circle fa-lg text-danger"></i> There was an error that prevented the application from working correctly.</p>

        <div class="card">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Details</h4>
            </div>
            <div class="card-body">
                <pre><code><?= htmlspecialchars($error) ?></code></pre>
            </div>
        </div>
    </div>

</div>
