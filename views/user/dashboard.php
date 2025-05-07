<?php require_once '../views/partials/header.php'; ?>

<h1 class="mb-4 animate__animated animate__fadeIn">Your Dashboard</h1>

<div class="row mb-4 animate__animated animate__fadeInUp">
    <div class="col-md-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Your Posts</h5>
                <p class="card-text display-4"><?php echo count($data['posts']); ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Profile</h5>
                <p class="card-text">View and edit your profile</p>
                <a href="<?php echo SITE_URL; ?>/user/profile" class="btn btn-light">Go to Profile</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">New Post</h5>
                <p class="card-text">Create a new blog post</p>
                <a href="<?php echo SITE_URL; ?>/blog/add" class="btn btn-light">Create Post</a>
            </div>
        </div>
    </div>
</div>

<h3 class="mb-3 animate__animated animate__fadeIn">Your Recent Posts</h3>

<div class="row animate__animated animate__fadeInUp">
    <?php foreach($data['posts'] as $post): ?>
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <?php if($post->featured_image): ?>
                    <img src="<?php echo SITE_URL . '/' . $post->featured_image; ?>" class="card-img-top" alt="<?php echo $post->title; ?>">
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $post->title; ?></h5>
                    <p class="card-text"><?php echo substr($post->content, 0, 100) . '...'; ?></p>
                    <p class="text-muted">Status: <span class="badge bg-<?php echo $post->status == 'published' ? 'success' : 'warning'; ?>"><?php echo ucfirst($post->status); ?></span></p>
                    <p class="text-muted">Posted on <?php echo date('M j, Y', strtotime($post->created_at)); ?></p>
                    <a href="<?php echo SITE_URL; ?>/blog/show/<?php echo $post->id; ?>" class="btn btn-primary">View</a>
                    <a href="<?php echo SITE_URL; ?>/blog/edit/<?php echo $post->id; ?>" class="btn btn-warning">Edit</a>
                    <form action="<?php echo SITE_URL; ?>/blog/delete/<?php echo $post->id; ?>" method="POST" class="d-inline">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php if(empty($data['posts'])): ?>
    <div class="alert alert-info animate__animated animate__fadeIn">
        You haven't created any posts yet. <a href="<?php echo SITE_URL; ?>/blog/add" class="alert-link">Create your first post</a>.
    </div>
<?php endif; ?>

<?php require_once '../views/partials/footer.php'; ?>