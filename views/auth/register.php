<?php require_once 'views/partials/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6 animate__animated animate__zoomIn">
        <div class="card">
            <div class="card-header">
                <h4>Register</h4>
            </div>
            <div class="card-body">
                <form action="<?php echo SITE_URL; ?>/auth/register" method="POST">
                    <div class="form-group mb-3">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['username']; ?>">
                        <span class="invalid-feedback"><?php echo $data['username_err']; ?></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                        <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                    <p class="mt-3">Already have an account? <a href="<?php echo SITE_URL; ?>/auth/login">Login here</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/partials/footer.php'; ?>