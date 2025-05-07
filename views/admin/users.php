<?php require_once 'views/partials/header.php'; ?>

<h1 class="mb-4 animate__animated animate__fadeIn">Manage Users</h1>

<div class="card animate__animated animate__fadeInUp">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>    
                <tbody>
                    <?php foreach($data['users'] as $user): ?>
                        <tr class="animate__animated animate__fadeIn">
                            <td><?php echo $user->id; ?></td>
                            <td><?php echo $user->username; ?></td>
                            <td><?php echo $user->email; ?></td>
                            <td>
                                <span class="badge bg-<?php echo $user->role == 'admin' ? 'danger' : 'primary'; ?>">
                                    <?php echo ucfirst($user->role); ?>
                                </span>
                            </td>
                            <td><?php echo date('M j, Y', strtotime($user->created_at)); ?></td>
                            <td>
                                <?php if($user->id != $_SESSION['user_id']): ?>
                                    <form action="<?php echo SITE_URL; ?>/admin/deleteUser/<?php echo $user->id; ?>" method="POST" class="d-inline">
                                        <input type="hidden" name="csrf_token" value="<?php echo generate_csrf_token(); ?>">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'views/partials/footer.php'; ?>