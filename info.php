<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();
$validate = new validate();
$successMessage = null;
$pageError = null;
$errorMessage = null;
$numRec = 8;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Logbook - Info</title>
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
            <h1>Welcome to Medilab</h1>
            <h2>We are team of talented designers making websites with Bootstrap</h2>
            <a href="#about" class="btn-get-started scrollto">Get Started</a>
        </div>
    </section> -->

    <!-- End Hero -->
    <main id="main">

        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container-fluid">
                <br>
                <hr>
                <br>
                <div class="row">
                    <!-- <div class="col-xl-5 col-lg-6 video-box d-flex justify-content-center align-items-stretch position-relative">
                        <a href="https://www.youtube.com/watch?v=jDDaplaOz7Q" class="glightbox play-btn mb-4"></a>
                    </div> -->

                    <?php
                    if ($_GET['disease'] == 1) {
                        $competencies = 'diabetes';
                    } elseif ($_GET['disease'] == 2) {
                        $competencies = 'cardiac';
                    } elseif ($_GET['disease'] == 3) {
                        $competencies = 'sickle_cell';
                    } elseif ($_GET['disease'] == 4) {
                        $competencies = 'respiratory';
                    } elseif ($_GET['disease'] == 5) {
                        $competencies = 'hypertension';
                    } elseif ($_GET['disease'] == 6) {
                        $competencies = 'epilepsy';
                    } elseif ($_GET['disease'] == 7) {
                        $competencies = 'liver';
                    } elseif ($_GET['disease'] == 8) {
                        $competencies = 'kidney';
                    }
                    ?>

                    <div class="col-xl-12 col-lg-12 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">

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
                        <?php } elseif ($_GET['msg']) { ?>
                            <div class="alert alert-success">
                                <h4>Success!</h4>
                                <?= $_GET['msg'] ?>
                            </div>
                        <?php } ?>
                        <!-- <section class="content-header"> -->
                        <!-- <div class="container-fluid"> -->
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>List of Activities Done <?= $competencies ?></h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="dashboard.php">
                                            < Back</a>
                                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                </ol>
                            </div>
                        </div>
                        <!-- </div> -->
                        <!-- /.container-fluid -->
                        <!-- </section> -->
                        <hr>
                        <?php if ($user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) { ?>

                            <a href="add.php?disease=<?= $_GET['disease'] ?>" class="btn btn-info">Add New Patient Visit</a>
                        <?php } ?>

                        <?php
                        if ($user->data()->accessLevel == 1 || $user->data()->accessLevel == 3) {
                            $pagNum = 0;
                            $pagNum = $override->countData('logs', 'status', 1, 'disease', $_GET['disease']);

                            $pages = ceil($pagNum / $numRec);
                            if (!$_GET['page'] || $_GET['page'] == 1) {
                                $page = 0;
                            } else {
                                $page = ($_GET['page'] * $numRec) - $numRec;
                            }
                            $data = $override->getWithLimit1('logs', 'status', 1, 'disease', $_GET['disease'], $page, $numRec);
                        } else {
                            $pagNum = 0;
                            $pagNum = $override->countData2('logs', 'status', 1, 'disease', $_GET['disease'], 'mentor', $user->data()->id);

                            $pages = ceil($pagNum / $numRec);
                            if (!$_GET['page'] || $_GET['page'] == 1) {
                                $page = 0;
                            } else {
                                $page = ($_GET['page'] * $numRec) - $numRec;
                            }
                            $data = $override->getWithLimit3('logs', 'status', 1, 'disease', $_GET['disease'], 'mentor', $user->data()->id, $page, $numRec);
                        }
                        ?>


                        <hr>
                        <div class="card-body">
                            <table id="search-results" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Visit Date</th>
                                        <th>Mentee Name</th>
                                        <th>Menter Name</th>
                                        <th>PID</th>
                                        <th>Site</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $x = 1;
                                    foreach ($data as $value) {
                                        $mentor = $override->getNews('user', 'status', 1, 'id', $value['mentor'])[0];
                                        $mentee = $override->getNews('user', 'status', 1, 'id', $value['mentee'])[0];
                                        $site = $override->getNews('site', 'status', 1, 'id', $value['site_id'])[0];

                                    ?>
                                        <tr>
                                            <td>
                                                <?= $x; ?>
                                            </td>
                                            <td class="table-user">
                                                <?= $value['visit_date']; ?>
                                            </td>
                                            <td class="table-user">
                                                <?= $mentee['firstname'] . ' - ' . $mentee['lastname']; ?>
                                            </td>
                                            <td class="table-user">
                                                <?= $mentor['firstname'] . ' - ' . $mentor['lastname']; ?>
                                            </td>
                                            <td class="table-user">
                                                <?= $value['pids']; ?>
                                            </td>
                                            <td class="table-user">
                                                <?= $site['name']; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) { ?>
                                                    <a href="add.php?id=<?= $value['id'] ?>&disease=<?= $value['disease'] ?>" class="btn btn-info">Update</a>
                                                <?php } ?>
                                                <?php if ($user->data()->accessLevel == 1 || $user->data()->accessLevel == 2 || $user->data()->accessLevel == 3) { ?>

                                                    <a href="add.php?id=<?= $value['id'] ?>&disease=<?= $value['disease'] ?>" class="btn btn-success">View</a>
                                                <?php } ?>

                                                <?php if ($user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) { ?>

                                                    <a href="#delete<?= $value['id'] ?>" role="button" class="btn btn-danger" data-toggle="modal">Delete</a>
                                                <?php } ?>

                                            </td>
                                        </tr>
                                    <?php
                                        $x++;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Visit Date</th>
                                        <th>Mentee Name</th>
                                        <th>Menter Name</th>
                                        <th>PID</th>
                                        <th>Site</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item">
                                    <a class="page-link" href="info.php?disease=<?= $_GET['disease'] ?>&page=<?php if (($_GET['page'] - 1) > 0) {
                                                                                                                    echo $_GET['page'] - 1;
                                                                                                                } else {
                                                                                                                    echo 1;
                                                                                                                } ?>">&laquo;
                                    </a>
                                </li>
                                <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                    <li class="page-item">
                                        <a class="page-link <?php if ($i == $_GET['page']) {
                                                                echo 'active';
                                                            } ?>" href="info.php?disease=<?= $_GET['disease'] ?>&page=<?= $i ?>"><?= $i ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <li class="page-item">
                                    <a class="page-link" href="info.php?disease=<?= $_GET['disease'] ?>&page=<?php if (($_GET['page'] + 1) <= $pages) {
                                                                                                                    echo $_GET['page'] + 1;
                                                                                                                } else {
                                                                                                                    echo $i - 1;
                                                                                                                } ?>">&raquo;
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </section><!-- End About Section -->

    </main><!-- End #main -->

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