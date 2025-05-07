<?php require_once 'views/partials/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6 text-center animate__animated animate__fadeIn">
        <div class="card">
            <div class="card-body">
                <h1 class="display-1 text-danger">404</h1>
                <h3 class="mb-4">Page Not Found</h3>
                <p class="lead">The page you are looking for doesn't exist or has been moved.</p>
                <a href="<?php echo SITE_URL; ?>" class="btn btn-primary mt-3">
                    <i class="fas fa-home"></i> Go Back Home
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/partials/footer.php'; ?>