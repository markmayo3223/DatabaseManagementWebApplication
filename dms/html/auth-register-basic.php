<?php
session_start();
include '../functions/config.php';


if (isset($_POST['submit'])) {



  try {
    $email=$_POST['email'];

    $name=ucwords($_POST['name']);
    $password=$_POST['password'];
    $position=$_POST['position'];

      $userProperties=[
        'email'=>$email,
        'displayName'=>$name,
        'password'=>$password,
      ];
    $createdUser=$auth->createUser($userProperties);

      if($createdUser){
        $uid=$createdUser->uid;
        if ($position=='LDRRM Head') {
        $auth->setCustomUserClaims($uid, ['admin' => 1,'approved'=>false,'position'=>$position]);

      }elseif ($position=='Guest') {
        $auth->setCustomUserClaims($uid, ['admin' => 0,'approved'=>false,'position'=>$position]);
      }
      else{
        $auth->setCustomUserClaims($uid, ['admin' => 2,'approved'=>false,'position'=>$position]);
      }
        $claims = $auth->getUser($uid)->customClaims;


        //$auth->sendEmailVerificationLink($email);
        $actionCodeSettings = [
    'continueUrl' => 'https://dev.x10.bz/dms/',
];
        $link = $auth->getEmailVerificationLink($email,$actionCodeSettings);
        $data=[
          'id'=>$createdUser->uid,
        'name'=>$createdUser->displayName,
        'email'=>$createdUser->email,
        'position'=>$position
        ];

      $ref_table='USERS/'.$createdUser->uid;
      $updatequery_result=$database->getReference($ref_table)->set($data);
// var_dump($updatequery_result);
      $success="Please check your email for verification.";
      $action="Email Verification";
      include '../mail/test.php';
// exit();
    }
    }catch(Exception $e){

      if(str_contains($e,'already in use')){
      $error="Email already in use";

      // header("Location: register.php");
      }

    }
}

 ?>
<!DOCTYPE html>
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <link rel="icon" type="image/x-icon" href="../assets/img/logos/cdrrmologo.png" />

    <title>Register - eFileCabinet</title>

    <meta name="description" content="" />
<?php include '../includes/head.php'; ?>
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">

      <div class="authentication-wrapper authentication-basic container-p-y">

        <div class="authentication-inner">

          <!-- Register Card -->
          <div class="card">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <img src="../assets/img/logos/cdrrmologo.png" alt="" height="50px" width="50px">
                  </span>
                  <span class="app-brand-text text-body fw-bolder">eFileCabinet.gov</span>
                </a>
              </div>
              <!-- /Logo -->
              <p class="mb-4">Sing up to continue..</p>
              <h4 class="mb-2">eFile Cabinet</h4>

              <form id="formAuthentication" class="mb-3" action="auth-register-basic.php" method="POST">
                <div class="mb-3">
                  <label for="text" class="form-label">Name</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required/>
                </div>
                <div class="mb-3">
                  <label for="exampleFormControlSelect1" class="form-label">Select Position</label>
                  <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" name="position" required>
                    <option selected>Position</option>
                    <option value="LDRRM Head">LDRRM Head</option>
                    <option value="Guest">Guest</option>
                    <option value="Receiving">Receiving</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="text" autocomplete="false" class="form-control" id="email" name="email" placeholder="Enter your email" required/>
                </div>
                <div class="mb-3 form-password-toggle">
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password"
                      autocomplete="false"
                      required
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <?php
                if (isset($success)) {
                  echo '<div class="alert alert-success d-flex" role="alert">
    <span class="badge badge-center rounded-pill bg-success border-label-success p-3 me-2">
      <i class="bx bx-check fs-6"></i></span>
    <div class="d-flex flex-column ps-1">
      <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Success</h6>
      <span>Please Check your email for verification.</span>
    </div>
  </div>';
                }
                if(isset($error)){
                  echo '<div class="alert alert-danger d-flex" role="alert">
    <span class="badge badge-center rounded-pill bg-danger border-label-danger p-3 me-2">
      <i class="bx bx-x fs-6"></i></span>
    <div class="d-flex flex-column ps-1">
      <h6 class="alert-heading d-flex align-items-center fw-bold mb-1">Error</h6>
      <span>'.$error.'</span>
    </div>
  </div>';
                }

                 ?>


                <button type="submit" name="submit" class="btn btn-primary d-grid w-100">Sign up</button>
              </form>

              <p class="text-center">
                <span>Already have an account?</span>
                <a href="auth-login-basic.php">
                  <span>Sign in instead</span>
                </a>
              </p>
            </div>
          </div>
          <!-- Register Card -->
        </div>
      </div>
    </div>

    <!-- / Content -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>
  <script src="../assets/js/ui-toasts.js"></script>
    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
