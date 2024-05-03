<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

$users = $override->getData('user');
if (Input::exists('post')) {

    if (Input::get('search_by_site1')) {
        $validate = new validate();
        $validate = $validate->check($_POST, array(
            'site_id' => array(
                'required' => true,
            ),
        ));
        if ($validate->passed()) {

            $url = 'index1.php?&site_id=' . Input::get('site_id');
            Redirect::to($url);
            $pageError = $validate->errors();
        }
    }
}


if ($user->isLoggedIn()) {

    if ($user->data()->accessLevel == 1 || $user->data()->accessLevel == 3) {
        if ($_GET['site_id'] != null) {
            $screened = $override->countData2('clients', 'status', 1, 'screened', 1, 'site_id', $_GET['site_id']);
            $eligible = $override->countData2('clients', 'status', 1, 'eligible', 1, 'site_id', $_GET['site_id']);
            $enrolled = $override->countData2('clients', 'status', 1, 'enrolled', 1, 'site_id', $_GET['site_id']);
            $end = $override->countData2('clients', 'status', 1, 'end_study', 1, 'site_id', $_GET['site_id']);
        } else {
            $screened = $override->countData('clients', 'status', 1, 'screened', 1);
            $eligible = $override->countData('clients', 'status', 1, 'eligible', 1);
            $enrolled = $override->countData('clients', 'status', 1, 'enrolled', 1);
            $end = $override->countData('clients', 'status', 1, 'end_study', 1);
        }
    } else {
        $screened = $override->countData2('clients', 'status', 1, 'screened', 1, 'site_id', $user->data()->site_id);
        $eligible = $override->countData2('clients', 'status', 1, 'eligible', 1, 'site_id', $user->data()->site_id);
        $enrolled = $override->countData2('clients', 'status', 1, 'enrolled', 1, 'site_id', $user->data()->site_id);
        $end = $override->countData2('clients', 'status', 1, 'end_study', 1, 'site_id', $user->data()->site_id);
    }
} else {
    Redirect::to('index.php');
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

    <!-- ======= Top Bar ======= -->
    <?php include 'topbar.php' ?>


    <!-- ======= Header ======= -->
    <?php include 'header.php' ?>
    <!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <!-- <section id="hero" class="d-flex align-items-center">
        <div class="container">
            <h1>PenPlus LogBook</h1> -->
    <!-- <h2>We are team of talented designers making websites with Bootstrap</h2> -->
    <!-- <a href="#about" class="btn-get-started scrollto">Get Started</a>
        </div>
    </section> -->
    <!-- End Hero -->

    <main id="main">

        <!-- ======= Why Us Section ======= -->
        <?php
        // include 'why_us.php';
        ?>
        <!-- End Why Us Section -->

        <!-- ======= About Section ======= -->
        <?php
        // include 'about.php';
        ?>
        <!-- End About Section -->

        <!-- ======= Counts Section ======= -->
        <?php
        // include 'counts.php';
        ?>
        <!-- End Counts Section -->

        <!-- ======= Services Section ======= -->
        <?php
        include 'services.php';
        ?>
        <!-- End Services Section -->

        <!-- ======= Appointment Section ======= -->
        <?php
        // include 'appointment.php';
        ?>
        <!-- End Appointment Section -->

        <!-- ======= Departments Section ======= -->
        <?php
        // include 'departments.php';
        ?>
        <!-- End Departments Section -->

        <!-- ======= Doctors Section ======= -->
        <?php
        // include 'doctors.php';
        ?>
        <!-- End Doctors Section -->

        <!-- ======= Frequently Asked Questions Section ======= -->
        <?php
        // include 'faq.php';
        ?>

        <!-- End Frequently Asked Questions Section -->

        <!-- ======= Testimonials Section ======= -->
        <?php
        // include 'testimonials.php';
        ?>
        <!-- End Testimonials Section -->

        <!-- ======= Gallery Section ======= -->
        <?php
        // include 'gallery.php';
        ?>
        <!-- End Gallery Section -->

        <!-- ======= Contact Section ======= -->
        <?php
        // include 'contact.php';
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