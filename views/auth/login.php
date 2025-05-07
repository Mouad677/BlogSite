<?php require_once '../views/partials/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6 animate__animated animate__zoomIn">
        <div class="card">
            <div class="card-header">
                <h4>Login</h4>
            </div>
            <div class="card-body">
                <form action="<?php echo SITE_URL; ?>/auth/login" method="POST">
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
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                    <p class="mt-3">Don't have an account? <a href="<?php echo SITE_URL; ?>/auth/register">Register here</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../views/partials/footer.php'; ?>