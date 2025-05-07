<?php require_once '../views/partials/header.php'; ?>

<h1 class="mb-4 animate__animated animate__fadeIn">Admin Dashboard</h1>

<div class="row animate__animated animate__fadeInUp">
    <div class="col-md-6 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <p class="card-text display-4"><?php echo $data['users_count']; ?></p>
                <a href="<?php echo SITE_URL; ?>/admin/users" class="btn btn-light">View Users</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Total Posts</h5>
                <p class="card-text display-4"><?php echo $data['posts_count']; ?></p>
                <a href="<?php echo SITE_URL; ?>/admin/posts" class="btn btn-light">View Posts</a>
            </div>
        </div>
    </div>
</div>

<div class="card animate__animated animate__fadeIn">
    <div class="card-header">
        <h3>Quick Actions</h3>
    </div>
    <div class="card-body">
        <div class="d-grid gap-2 d-md-block">
            <a href="<?php echo SITE_URL; ?>/blog/add" class="btn btn-primary me-md-2 mb-2">
                <i class="fas fa-plus"></i> Add New Post
            </a>
            <a href="<?php echo SITE_URL; ?>/admin/users" class="btn btn-secondary me-md-2 mb-2">
                <i class="fas fa-users"></i> Manage Users
            </a>
            <a href="<?php echo SITE_URL; ?>/admin/posts" class="btn btn-info me-md-2 mb-2">
                <i class="fas fa-newspaper"></i> Manage Posts
            </a>
        </div>
    </div>
</div>

<?php require_once '../views/partials/footer.php'; ?>