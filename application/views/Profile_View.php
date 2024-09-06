<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SnapsWay</title>
    <link rel="stylesheet" href="<?php echo base_url('CSS/profile.css'); ?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand mr-auto ml-5 " href="#">SNAPSWAY</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mr-5" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('index.php/Login/dashboard'); ?>">News Feed <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item  active">
                    <a class="nav-link" href="<?php echo base_url('index.php/Login/profile'); ?>">My Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('index.php/Login/logout'); ?>">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="Main-container">
        <div class="left-section">
            <div class="left-section-content">
            </div>
        </div>
        <div class="middle-section">
            <div class="middle-wrapper">
                <div class="middle-section-content">
                    <div class="profile-details">
                        <div class="profile-details-header">
                            <div class="profile-details-image">
                                <img src="<?php echo $user['profile_picture']; ?>" alt="" class="pro-image" />
                            </div>
                        </div>
                        <div class="profile-details-bottom">
                            <p><?php echo $user['name']; ?></p>
                            <p>Email : <?php echo $user['email']; ?></p>
                            <p>Friends : <?php echo $friendCount; ?></p>
                            <p>Bio : <?php echo $user['bio']; ?></p>
                            <form action="<?= base_url('index.php/Register/edit_profile') ?>" method="post">
                                <button type="submit" class="btn btn-outline-dark btn-sm">Edit Profile&nbsp;&nbsp; <i class="fa-solid fa-gear"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="post-container">
                        <div class="post-header">
                            <div class="friend-request-image">
                                <img src="<?php echo $user['profile_picture']; ?>" alt="image" class="rqst-pro-image" />
                            </div>
                            <p class="post-owner-name"> <?php echo $user['name']; ?></p>
                        </div>
                        <div class="post-bottom">
                            <div class="comments-section create-post">
                                <form action="<?= base_url('index.php/Post/create') ?>" method="post">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">
                                            <i class="fa-solid fa-pen-to-square"></i> Create New Post
                                        </label>
                                        <textarea class="form-control" name="caption" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputImageLink">Image Link</label>
                                        <input type="text" class="form-control" name="image_url" id="exampleInputImageLink" placeholder="Enter your image link here" />
                                    </div>
                                    <button type="submit" class="btn btn-outline-dark btn-sm">Create Post</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($posts)) : ?>
                        <?php foreach ($posts as $post) : ?>
                            <div class="post-container">
                                <div class="post-header">
                                    <div class="friend-request-image">
                                        <img src="<?php echo $user['profile_picture']; ?>" alt="image" class="rqst-pro-image" />
                                    </div>
                                    <p class="post-owner-name"> <?php echo $user['name']; ?></p>
                                </div>
                                <div class="post-bottom">
                                    <p><?= $post['caption'] ?></p>
                                    <div class="post-image">
                                        <img src="<?= $post['image_url'] ?>" class="img-fluid post-img" alt="Responsive image" />
                                    </div>
                                    <div class="comments-section">
                                        <?php if (!empty($post['comments'])) : ?>
                                            <?php foreach ($post['comments'] as $comment) : ?>
                                                <div class="one-comment">
                                                    <div class="one-comment-top">
                                                        <div>
                                                            <p class="commented-user-name"><?= $comment['commented_user_name'] ?></p>
                                                        </div>
                                                        <div>
                                                            <form action="<?php echo base_url('index.php/Login/delete_comment/' . $comment['comment_id']); ?>" method="post">
                                                                <button type="submit" class="btn btn-outline-dark btn-sm">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <p class="comment-text">
                                                        <?= $comment['comment_text'] ?>
                                                    </p>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <p>No comments yet</p>
                                        <?php endif; ?>
                                        <div>
                                            <form action="<?php echo base_url('index.php/Post/delete/' . $post['post_id']); ?>" method="post">
                                                <input type="hidden" name="post_id" value="<?= $post['post_id'] ?>">
                                                <button type="submit" class="btn btn-outline-dark btn-sm mt-2">Delete Post &nbsp; <i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>No posts found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="right-section">
            <div class="right-section-content">
            </div>
        </div>
    </div>
</body>

</html>