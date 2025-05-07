<?php require_once '../views/partials/header.php'; ?>

<div class="animate__animated animate__fadeIn">
    <div class="mb-4">
        <a href="<?php echo SITE_URL; ?>/blog" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Posts
        </a>
        
        <?php if(isLoggedIn() && ($_SESSION['user_id'] == $data['post']->user_id || isAdmin())): ?>
            <a href="<?php echo SITE_URL; ?>/blog/edit/<?php echo $data['post']->id; ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="<?php echo SITE_URL; ?>/blog/delete/<?php echo $data['post']->id; ?>" method="POST" class="d-inline">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        <?php endif; ?>
    </div>

    <h1 class="mb-3"><?php echo $data['post']->title; ?></h1>
    
    <?php if($data['post']->featured_image): ?>
        <img src="<?php echo SITE_URL . '/' . $data['post']->featured_image; ?>" class="img-fluid mb-4 rounded" alt="<?php echo $data['post']->title; ?>">
    <?php endif; ?>
    
    <div class="mb-4">
        <p class="text-muted">
            Posted by <?php echo $data['post']->username; ?> on <?php echo date('M j, Y', strtotime($data['post']->created_at)); ?>
        </p>
        <p class="badge bg-<?php echo $data['post']->status == 'published' ? 'success' : 'warning'; ?>">
            <?php echo ucfirst($data['post']->status); ?>
        </p>
    </div>
    
    <div class="post-content mb-5">
        <?php echo $data['post']->content; ?>
    </div>
    
    <hr>
    
    <div class="comments-section mt-5">
        <h3 class="mb-4">Comments</h3>
        
        <?php if(isLoggedIn()): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <form action="<?php echo SITE_URL; ?>/blog/addComment/<?php echo $data['post']->id; ?>" method="POST">
                        <div class="form-group">
                            <textarea name="content" class="form-control <?php echo (!empty($data['content_err'])) ? 'is-invalid' : ''; ?>" placeholder="Add a comment..."></textarea>
                            <span class="invalid-feedback"><?php echo $data['content_err'] ?? ''; ?></span>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Submit</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <p>Please <a href="<?php echo SITE_URL; ?>/auth/login">login</a> to post a comment.</p>
        <?php endif; ?>
        
        <?php foreach($data['comments'] as $comment): ?>
            <div class="card mb-3 animate__animated animate__fadeIn">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title"><?php echo $comment->username; ?></h5>
                        <small class="text-muted"><?php echo date('M j, Y g:i a', strtotime($comment->created_at)); ?></small>
                    </div>
                    <p class="card-text"><?php echo $comment->content; ?></p>
                    
                    <?php if(isLoggedIn() && ($_SESSION['user_id'] == $comment->user_id || isAdmin())): ?>
                        <form action="<?php echo SITE_URL; ?>/blog/deleteComment/<?php echo $comment->id; ?>" method="POST" class="d-inline">
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php if(empty($data['comments'])): ?>
            <p class="text-muted">No comments yet. Be the first to comment!</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../views/partials/footer.php'; ?>