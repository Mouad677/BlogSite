<?php require_once '../views/partials/header.php'; ?>

<h1 class="mb-4 animate__animated animate__fadeIn">Manage Posts</h1>

<div class="card animate__animated animate__fadeInUp">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['posts'] as $post): ?>
                        <tr class="animate__animated animate__fadeIn">
                            <td><?php echo $post->id; ?></td>
                            <td><?php echo $post->title; ?></td>
                            <td><?php echo $post->username; ?></td>
                            <td>
                                <span class="badge bg-<?php echo $post->status == 'published' ? 'success' : 'warning'; ?>">
                                    <?php echo ucfirst($post->status); ?>
                                </span>
                            </td>
                            <td><?php echo date('M j, Y', strtotime($post->created_at)); ?></td>
                            <td>
                                <a href="<?php echo SITE_URL; ?>/blog/show/<?php echo $post->id; ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="<?php echo SITE_URL; ?>/blog/edit/<?php echo $post->id; ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="<?php echo SITE_URL; ?>/blog/delete/<?php echo $post->id; ?>" method="POST" class="d-inline">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../views/partials/footer.php'; ?>