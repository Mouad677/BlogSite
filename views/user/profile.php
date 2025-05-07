<?php require_once '../views/partials/header.php'; ?>

<div class="row animate__animated animate__fadeIn">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h3>Profile Information</h3>
            </div>
            <div class="card-body">
                <form action="<?php echo SITE_URL; ?>/user/profile" method="POST">
                    <div class="form-group mb-3">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['username']; ?>">
                        <span class="invalid-feedback"><?php echo $data['username_err'] ?? ''; ?></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                        <span class="invalid-feedback"><?php echo $data['email_err'] ?? ''; ?></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Change Password</h3>
            </div>
            <div class="card-body">
                <form action="<?php echo SITE_URL; ?>/user/changePassword" method="POST">
                    <div class="form-group mb-3">
                        <label for="current_password">Current Password</label>
                        <input type="password" name="current_password" class="form-control <?php echo (!empty($data['current_password_err'])) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $data['current_password_err'] ?? ''; ?></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="new_password">New Password</label>
                        <input type="password" name="new_password" class="form-control <?php echo (!empty($data['new_password_err'])) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $data['new_password_err'] ?? ''; ?></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" name="confirm_password" class="form-control <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $data['confirm_password_err'] ?? ''; ?></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../views/partials/footer.php'; ?>