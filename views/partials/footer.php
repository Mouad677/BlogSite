<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> | <?php echo $data['title'] ?? ''; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="<?php echo SITE_URL; ?>/assets/css/style.css" rel="stylesheet">
    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body>
    <?php require_once 'navigation.php'; ?>
    
    <div class="container mt-4 animate__animated animate__fadeIn">
        <?php flash('register_success'); ?>
        <?php flash('post_message'); ?>
        <?php flash('comment_message'); ?>
        <?php flash('profile_message'); ?>
        <?php flash('admin_message'); ?>