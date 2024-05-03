<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();
$validate = new validate();

// $successMessage = null;
// $pageError = null;
// $errorMessage = null;


$data = null;
$filename = null;

$data = $override->get('logs', 'status', 1);
$filename = 'Mentoring Data';
$user->exportData($data, $filename);
