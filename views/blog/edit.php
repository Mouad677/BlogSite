<?php require_once '../views/partials/header.php'; ?>

<div class="card animate__animated animate__fadeIn">
    <div class="card-header">
        <h3>Edit Post</h3>
    </div>
    <div class="card-body">
        <form action="<?php echo SITE_URL; ?>/blog/edit/<?php echo $data['id']; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
                <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="featured_image">Featured Image</label>
                <input type="file" name="featured_image" class="form-control">
                <?php if($data['featured_image']): ?>
                    <div class="mt-2">
                        <img src="<?php echo SITE_URL . '/' . $data['featured_image']; ?>" class="img-thumbnail" style="max-width: 200px;">
                        <p class="text-muted mt-1">Current image</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group mb-3">
                <label for="content">Content</label>
                <textarea name="content" class="form-control <?php echo (!empty($data['content_err'])) ? 'is-invalid' : ''; ?>" rows="10"><?php echo $data['content']; ?></textarea>
                <span class="invalid-feedback"><?php echo $data['content_err']; ?></span>
            </div>
            <div class="form-group mb-3">
                <label for="status">Status</label>
                <select name="status" class="form-control">
                    <option value="draft" <?php echo $data['status'] == 'draft' ? 'selected' : ''; ?>>Draft</option>
                    <option value="published" <?php echo $data['status'] == 'published' ? 'selected' : ''; ?>>Published</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?php echo SITE_URL; ?>/blog/show/<?php echo $data['id']; ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php require_once '../views/partials/footer.php'; ?>