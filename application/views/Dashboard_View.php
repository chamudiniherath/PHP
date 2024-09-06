<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SnapsWay</title>
  <link rel="stylesheet" href="<?php echo base_url('CSS/styles.css'); ?>" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand mr-auto ml-5" href="#">SNAPSWAY</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mr-5" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo base_url('index.php/Login/dashboard'); ?>">News Feed <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
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
        <p class="rqst-headers">Friend Requests</p>
        <?php if (!empty($received_requests)) : ?>
          <?php foreach ($received_requests as $request) : ?>
            <div class="friend-request">
              <div class="friend-request-top">
                <p class="rqst-name"><?php echo $request['sender_name']; ?></p>
              </div>
              <div class="friend-request-bottom">
                <div class="friend-request-img-section">
                  <div class="friend-request-image">
                    <img src="<?php echo $request['sender_profile_picture']; ?>" alt="image" class="rqst-pro-image" />
                  </div>
                </div>
                <div class="friend-request-button-section">
                  <form action="<?php echo base_url('index.php/Login/accept_friend_request/' . $request['request_id']); ?>" method="post">
                    <input type="hidden" name="request_id" value="<?= $request['request_id'] ?>">
                    <button type="submit" class="frnd-btn">Accept</button>
                  </form>
                  <form action="<?php echo base_url('index.php/Login/decline_request/' . $request['request_id']); ?>" method="post">
                    <input type="hidden" name="request_id" value="<?= $request['request_id'] ?>">
                    <button type="submit" class="frnd-btn decline">Decline</button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else : ?>
          <p>No friend requests.</p>
        <?php endif; ?>
        <div class="border-for-rqst"></div>
        <p class="rqst-headers">Friend Suggestions</p>
        <?php foreach ($other_users as $other_user) : ?>
          <div class="friend-request">
            <div class="friend-request-top">
              <p class="rqst-name"><?php echo $other_user['name']; ?></p>
            </div>
            <div class="friend-request-bottom">
              <div class="friend-request-img-section">
                <div class="friend-request-image">
                  <img src="<?php echo $other_user['profile_picture']; ?>" alt="image" class="rqst-pro-image" />
                </div>
              </div>
              <div class="friend-request-button-section">
                <form action="<?php echo base_url('index.php/Login/send_friend_request/' . $other_user['user_id']); ?>" method="post">
                  <button type="submit" class="send-rqst">Add Friend</button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
        <div class="border-for-rqst rqst-ovr"></div>
      </div>
    </div>
    <div class="middle-section">
      <div class="middle-section-content">
        <?php if (!empty($friends_posts)) : ?>
          <?php foreach ($friends_posts as $friend_post) : ?>
            <div class="post-container">
              <div class="post-header">
                <div class="friend-request-image">
                  <img src="<?php echo $friend_post['friends_post_pro']; ?>" alt="image" class="rqst-pro-image" />
                </div>
                <p class="post-owner-name"><?php echo $friend_post['user_name']; ?></p>
              </div>
              <div class="post-bottom">
                <p>
                  <?php echo $friend_post['friends_caption']; ?>
                </p>
                <div class="post-image">
                  <img src="  <?php echo $friend_post['friends_imageurl']; ?>" class="img-fluid post-img" alt="Responsive image" />
                </div>
                <div class="comments-section">
                  <?php if (!empty($friend_post['comments'])) : ?>
                    <?php foreach ($friend_post['comments'] as $comment) : ?>
                      <div class="one-comment">
                        <p class="commented-user-name"><?php echo $comment['commented_user_name']; ?></p>
                        <p class="comment-text">
                          <?php echo $comment['comment_text']; ?>
                        </p>
                      </div>
                    <?php endforeach; ?>
                  <?php else : ?>
                    <p>No comments yet.</p>
                  <?php endif; ?>
                  <form action="<?php echo base_url('index.php/Login/add_comment'); ?>" method="post">
                    <div class="form-group">
                        <label for="commentText">Comment <i class="fa-regular fa-comment"></i></label>
                        <textarea class="form-control" id="commentText" name="comment_text" rows="3"></textarea>
                    </div>
                    <input type="hidden" name="post_id" value="<?php echo $friend_post['post_id']; ?>">
                    <button type="submit" class="btn btn-outline-dark btn-sm">Add my comment</button>
                </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
          </ul>
        <?php else : ?>
          <p>No posts from friends yet.</p>
        <?php endif; ?>
        <p class="no-posts">Come back later to see new contents</p>
      </div>
    </div>
    <div class="right-section">
      <div class="right-section-content">
        <div class="right-section-profile-details">
          <div class="friend-request-image">
            <img src="<?php echo $logged_in_user['profile_picture']; ?>" alt="image" class="rqst-pro-image" />
          </div>
          <?php if (isset($logged_in_user)) : ?>
            <p class="post-owner-name"><?php echo $logged_in_user['name']; ?></p>
        </div>
        <div class="right-profile-details">
          <p>Status : online</p>
          <?php $friendCount = count($friends); ?>
          <p>Friends: <?php echo $friendCount; ?></p>
          <p>Email : <?php echo $logged_in_user['email']; ?> </p>
        <?php endif; ?>
        </div>
        <div class="border-for-rqst"></div>
        <p class="rqst-headers">Friends</p>
        <?php if (!empty($friends)) : ?>
          <?php foreach ($friends as $friend) : ?>
            <div class="friend-request">
              <div class="friend-request-top">
                <p class="rqst-name"><?php echo $friend['name']; ?></p>
              </div>
              <div class="friend-request-bottom">
                <div class="friend-request-img-section">
                  <div class="friend-request-image">
                    <img src="<?php echo $friend['profile_picture']; ?>" alt="image" class="rqst-pro-image" />
                  </div>
                </div>
                <div class="friend-request-button-section">
                  <form action="<?php echo base_url('index.php/Login/unfriend/' . $friend['user_id']); ?>" method="post">
                    <input type="hidden" name="receiver_id" value="<?= $friend['user_id'] ?>">
                    <button type="submit" class="frnd-btn decline">Unfriend</button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else : ?>
          <p>You don't have friends yet.</p>
        <?php endif; ?>
        <div class="border-for-rqst"></div>
        <p class="rqst-headers">Sent Requests</p>
        <?php if (!empty($sent_requests)) : ?>
          <?php foreach ($sent_requests as $request) : ?>
            <div class="friend-request">
              <div class="friend-request-top">
                <p class="rqst-name"><?php echo $request['receiver_name']; ?></p>
              </div>
              <div class="friend-request-bottom">
                <div class="friend-request-img-section">
                  <div class="friend-request-image">
                    <img src="<?php echo $request['receiver_profile_picture']; ?>" alt="image" class="rqst-pro-image" />
                  </div>
                </div>
                <div class="friend-request-button-section">
                  <form action="<?php echo base_url('index.php/Login/cancel_request/' . $request['request_id']); ?>" method="post">
                    <input type="hidden" name="request_id" value="<?= $request['request_id'] ?>">
                    <button type="submit" class="cancel-rqst">Cancel Request</button>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else : ?>
          <p>No pending sent friend requests.</p>
        <?php endif; ?>
        <div class="border-for-rqst"></div>
      </div>
    </div>
  </div>
</body>

</html>