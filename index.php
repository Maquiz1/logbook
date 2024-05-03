<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$usr = null;
$email = new Email();
$st = null;
$random = new Random();
$pageError = null;
$successMessage = null;
$errorM = false;
$errorMessage = null;
if (!$user->isLoggedIn()) {
  if (Input::exists('post')) {
    if (Token::check(Input::get('token'))) {
      $validate = new validate();
      $validate = $validate->check($_POST, array(
        'username' => array('required' => true),
        'password' => array('required' => true)
      ));
      if ($validate->passed()) {
        $st = $override->get('user', 'username', Input::get('username'));
        if ($st) {
          if ($st[0]['count'] > 3) {
            $errorMessage = 'You Account have been deactivated,Someone was trying to access it with wrong credentials. Please contact your system administrator';
          } else {
            $login = $user->loginUser(Input::get('username'), Input::get('password'), 'user');
            if ($login) {
              $lastLogin = $override->get('user', 'id', $user->data()->id);
              if ($lastLogin[0]['last_login'] == date('Y-m-d')) {
              } else {
                try {
                  $user->updateRecord('user', array(
                    'last_login' => date('Y-m-d H:i:s'),
                    'count' => 0,
                  ), $user->data()->id);
                } catch (Exception $e) {
                }
              }
              try {
                $user->updateRecord('user', array(
                  'count' => 0,
                ), $user->data()->id);
              } catch (Exception $e) {
              }

              Redirect::to('dashboard.php');
            } else {
              $usr = $override->get('user', 'username', Input::get('username'));
              if ($usr && $usr[0]['count'] < 3) {
                try {
                  $user->updateRecord('user', array(
                    'count' => $usr[0]['count'] + 1,
                  ), $usr[0]['id']);
                } catch (Exception $e) {
                }
                $errorMessage = 'Wrong username or password';
              } else {
                try {
                  $user->updateRecord('user', array(
                    'count' => $usr[0]['count'] + 1,
                  ), $usr[0]['id']);
                } catch (Exception $e) {
                }
                $email->deactivation($usr[0]['email_address'], $usr[0]['lastname'], 'Account Deactivated');
                $errorMessage = 'You Account have been deactivated,Someone was trying to access it with wrong credentials. Please contact your system administrator';
              }
            }
          }
        } else {
          $errorMessage = 'Invalid username, Please check your credentials and try again';
        }
      } else {
        $pageError = $validate->errors();
      }
    }
  }
} else {
  Redirect::to('dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Logbook - Penplus</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Medilab
  * Template URL: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/
  * Updated: Mar 17 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
  <!-- ======= Header ======= -->
  <?php include 'header.php' ?>
  <!-- End Header -->
  
  <!-- ======= Top Bar ======= -->
  <?php include 'topbar.php' ?>

  <!-- Main Sidebar Container -->
  <?php include 'sidemenu.php'; ?>
  <!--/. Main Sidebar Container -->

  <main id="main">

    <?php if ($errorMessage) { ?>
      <div class="alert alert-danger">
        <h4>Error!</h4>
        <?= $errorMessage ?>
      </div>
    <?php } elseif ($pageError) { ?>
      <div class="alert alert-danger">
        <h4>Error!</h4>
        <?php foreach ($pageError as $error) {
          echo $error . ' , ';
        } ?>
      </div>
    <?php } elseif ($successMessage) { ?>
      <div class="alert alert-success">
        <h4>Success!</h4>
        <?= $successMessage ?>
      </div>
    <?php } ?>
    <hr>
    <!-- ======= Contact Section ======= -->
    <?php
    include 'login.php';
    ?>
    <!-- End Contact Section -->

  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include 'footer.php' ?>

  <!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>