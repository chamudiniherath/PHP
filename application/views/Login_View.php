<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SnapsWay</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .ash-bg {
      background-color: #000000;
      height: 100vh;
    }

    .login-content {
      padding: 40px;
      background-color: #19181f;
      color: #FFFFFF;
      display: flex;
      justify-content: center;

    }

    .logo-container {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .logo-area {
      height: 350px;
      width: 350px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .logo-area img {
      max-width: 100%;
      max-height: 100%;
    }

    .form-container {
      margin-top: 70px;
      width: 60%;
    }

    .register-btn {
      margin-top: 20px;
      width: 100%;
      background-color: #7c5cf9;
      color: #FFFFFF;
      border: 1px solid #575e6c;
    }

    .form-control {
      background-color: #19181f !important;
      color: #FFFFFF;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6 ash-bg logo-container">
        <div class="logo-area ">
          <img src="<?php echo base_url('images/logo.png'); ?>" alt="snapsway logo">
        </div>
      </div>
      <div class="col-md-6 login-content">
        <div class="form-container">
          <h2 class="mb-5">User Login</h2>
          <?php if (isset($error)) : ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $error; ?>
            </div>
          <?php endif; ?>
          <form action="<?php echo base_url('index.php/Login/login_user'); ?>" method="post">
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
            </div>
            <button type="submit" class="btn register-btn">Login</button>
            <p class="mt-5">Don't have an account? <a href="<?php echo base_url(''); ?>">Create Account</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>