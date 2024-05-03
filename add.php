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
$numRec = 12;

if ($user->isLoggedIn()) {
    if (Input::exists('post')) {
        if (Input::get('add_user')) {
            $staff = $override->getNews('user', 'status', 1, 'id', $_GET['staff_id']);
            if ($staff) {
                $validate = $validate->check($_POST, array(
                    'firstname' => array(
                        'required' => true,
                    ),
                    'middlename' => array(
                        'required' => true,
                    ),
                    'lastname' => array(
                        'required' => true,
                    ),
                    'position' => array(
                        'required' => true,
                    ),
                    'site_id' => array(
                        'required' => true,
                    ),
                ));
            } else {
                $validate = $validate->check($_POST, array(
                    'firstname' => array(
                        'required' => true,
                    ),
                    'middlename' => array(
                        'required' => true,
                    ),
                    'lastname' => array(
                        'required' => true,
                    ),
                    'position' => array(
                        'required' => true,
                    ),
                    'site_id' => array(
                        'required' => true,
                    ),
                    'username' => array(
                        'required' => true,
                        'unique' => 'user'
                    ),
                    'phone_number' => array(
                        'required' => true,
                        'unique' => 'user'
                    ),
                    'email_address' => array(
                        'unique' => 'user'
                    ),
                ));
            }
            if ($validate->passed()) {
                $salt = $random->get_rand_alphanumeric(32);
                $password = '12345678';
                switch (Input::get('position')) {
                    case 1:
                        $accessLevel = 1;
                        break;
                    case 2:
                        $accessLevel = 1;
                        break;
                    case 3:
                        $accessLevel = 2;
                        break;
                    case 4:
                        $accessLevel = 3;
                        break;
                    case 5:
                        $accessLevel = 3;
                        break;
                    case 6:
                        $accessLevel = 3;
                        break;
                    case 7:
                        $accessLevel = 3;
                        break;
                    case 8:
                        $accessLevel = 3;
                        break;
                }
                try {

                    $staff = $override->getNews('user', 'status', 1, 'id', $_GET['staff_id']);

                    if ($staff) {
                        $user->updateRecord('user', array(
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'username' => Input::get('username'),
                            'phone_number' => Input::get('phone_number'),
                            'phone_number2' => Input::get('phone_number2'),
                            'email_address' => Input::get('email_address'),
                            'sex' => Input::get('sex'),
                            'position' => Input::get('position'),
                            'accessLevel' => Input::get('accessLevel'),
                            'power' => Input::get('power'),
                            // 'password' => Hash::make($password, $salt),
                            // 'salt' => $salt,
                            'site_id' => Input::get('site_id'),
                        ), $_GET['staff_id']);

                        $successMessage = 'Account Updated Successful';
                    } else {
                        $user->createRecord('user', array(
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'username' => Input::get('username'),
                            'phone_number' => Input::get('phone_number'),
                            'phone_number2' => Input::get('phone_number2'),
                            'email_address' => Input::get('email_address'),
                            'sex' => Input::get('sex'),
                            'position' => Input::get('position'),
                            'accessLevel' => $accessLevel,
                            'power' => Input::get('power'),
                            'password' => Hash::make($password, $salt),
                            'salt' => $salt,
                            'create_on' => date('Y-m-d'),
                            'last_login' => '',
                            'status' => 1,
                            'user_id' => $user->data()->id,
                            'site_id' => Input::get('site_id'),
                            'count' => 0,
                            'pswd' => 0,
                        ));
                        $successMessage = 'Account Created Successful';
                    }

                    Redirect::to('info.php?id=1&status=1');
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_position')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $position = $override->getNews('position', 'status', 1, 'id', $_GET['position_id']);
                    if ($position) {
                        $user->updateRecord('position', array(
                            'name' => Input::get('name'),
                        ), $position[0]['id']);
                        $successMessage = 'Position Successful Updated';
                    } else {
                        $user->createRecord('position', array(
                            'name' => Input::get('name'),
                            'access_level' => 1,
                            'status' => 1,
                        ));
                        $successMessage = 'Position Successful Added';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_site')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $user->createRecord('site', array(
                        'name' => Input::get('name'),
                    ));
                    $successMessage = 'Site Successful Added';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_logs')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                'pids' => array(
                    'required' => true,
                ),
                'site_id' => array(
                    'required' => true,
                ),
                'mentee' => array(
                    'required' => true,
                ),
                'site_id' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $log = $override->getNews('logs', 'status', 1, 'id', Input::get('id'))[0];
                    $competencies = implode(',', Input::get('competencies'));

                    if ($log) {
                        // foreach (Input::get('competencies') as $value) {
                        $user->updateRecord('logs', array(
                            'visit_date' => Input::get('visit_date'),
                            'competencies' => $competencies,
                            'pids' => Input::get('pids'),
                            'mentee' => Input::get('mentee'),
                            'notes' => Input::get('notes'),
                            'site_id' => Input::get('site_id'),
                        ), Input::get('id'));
                        // }
                        $successMessage = 'Logbook Successful Updated';
                    } else {
                        // foreach (Input::get('competencies') as $value) {
                        $user->createRecord('logs', array(
                            'visit_date' => Input::get('visit_date'),
                            'disease' => $_GET['disease'],
                            'competencies' => $competencies,
                            'cases' => 1,
                            'pids' => Input::get('pids'),
                            'mentee' => Input::get('mentee'),
                            'mentor' => $user->data()->id,
                            'notes' => Input::get('notes'),
                            'site_id' => Input::get('site_id'),
                            'status' => 1,
                        ));
                        // }
                        $successMessage = 'Logbook Successful Added';
                    }

                    Redirect::to('info.php?disease=' . $_GET['disease'] . '&msg=' . $successMessage);
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_visit')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
                'code' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $user->createRecord('schedule', array(
                        'name' => Input::get('name'),
                        'code' => Input::get('code'),
                    ));
                    $successMessage = 'Schedule Successful Added';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_demographic')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                'next_visit' => array(
                    'required' => true,
                ),
                'referred' => array(
                    'required' => true,
                ),
                'chw_name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    if (Input::get('referred') == 96 && empty(trim(Input::get('referred_other')))) {
                        $errorMessage = 'Please add a valaue from question " Patient referred from Other" Before you submit again';
                    } elseif (Input::get('referred') != 96 && !empty(trim(Input::get('referred_other')))) {
                        $errorMessage = 'Please remove a valaue from question " Patient referred from Other" Before you submit again';
                    } elseif (Input::get('chw_name') == 1 && empty(trim(Input::get('chw')))) {
                        $errorMessage = 'Please add a valaue from question " CHW name " If CHW name is available Before you submit again';
                    } elseif (Input::get('chw_name') == 2 && !empty(trim(Input::get('chw')))) {
                        $errorMessage = 'Please remove a valaue from question " CHW Name available " If CHW name is not available Before you submit again';
                    } else {

                        $demographic = $override->get3('demographic', 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq'], 'visit_code', $_GET['vcode'])[0];

                        if ($demographic) {
                            $user->updateRecord('demographic', array(
                                'visit_date' => Input::get('visit_date'),
                                'study_id' => $_GET['sid'],
                                'visit_code' => $_GET['vcode'],
                                'visit_day' => $_GET['vday'],
                                'seq_no' => $_GET['seq'],
                                'vid' => $_GET['vid'],
                                'household_size' => Input::get('household_size'),
                                'grade_age' => Input::get('grade_age'),
                                'school_attendance' => Input::get('school_attendance'),
                                'missed_school' => Input::get('missed_school'),
                                'next_visit' => Input::get('next_visit'),
                                'chw_name' => Input::get('chw_name'),
                                'chw' => Input::get('chw'),
                                'comments' => Input::get('comments'),
                                'referred' => Input::get('referred'),
                                'referred_other' => Input::get('referred_other'),
                                'patient_id' => $_GET['cid'],
                                'staff_id' => $user->data()->id,
                                'status' => 1,
                                'site_id' => $user->data()->site_id,
                            ), $demographic['id']);

                            $successMessage = 'Demographic added Successful';
                        } else {
                            $user->createRecord('demographic', array(
                                'visit_date' => Input::get('visit_date'),
                                'study_id' => $_GET['sid'],
                                'visit_code' => $_GET['vcode'],
                                'visit_day' => $_GET['vday'],
                                'seq_no' => $_GET['seq'],
                                'vid' => $_GET['vid'],
                                'household_size' => Input::get('household_size'),
                                'grade_age' => Input::get('grade_age'),
                                'school_attendance' => Input::get('school_attendance'),
                                'missed_school' => Input::get('missed_school'),
                                'next_visit' => Input::get('next_visit'),
                                'chw_name' => Input::get('chw_name'),
                                'chw' => Input::get('chw'),
                                'comments' => Input::get('comments'),
                                'referred' => Input::get('referred'),
                                'referred_other' => Input::get('referred_other'),
                                'patient_id' => $_GET['cid'],
                                'staff_id' => $user->data()->id,
                                'status' => 1,
                                'created_on' => date('Y-m-d'),
                                'site_id' => $user->data()->site_id,
                            ));
                            $successMessage = 'Demographic added Successful';
                        }
                        Redirect::to('info.php?id=7&cid=' . $_GET['cid'] . '&vid=' . $_GET['vid'] . '&vcode=' . $_GET['vcode'] . '&seq=' . $_GET['seq'] . '&sid=' . $_GET['sid'] . '&vday=' . $_GET['vday'] . '&status=' . $_GET['status'] . '&msg=' . $successMessage);
                        die;
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_main_diagnosis')) {
            $validate = $validate->check($_POST, array(
                'diagnosis_date' => array(
                    'required' => true,
                ),
                'cardiac' => array(
                    'required' => true,
                ),
                'diabetes' => array(
                    'required' => true,
                ),
                'sickle_cell' => array(
                    'required' => true,
                ),
                'other' => array(
                    'required' => true,
                ),

            ));
            if ($validate->passed()) {
                try {

                    $main_diagnosis = $override->get3('main_diagnosis', 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq'], 'visit_code', $_GET['vcode'])[0];

                    if ((Input::get('cardiac') == 1 && Input::get('diabetes') == 1 && Input::get('sickle_cell') == 1 && Input::get('other') == 1)
                        || (Input::get('cardiac') == 1 && Input::get('diabetes') == 1)
                        || (Input::get('cardiac') == 1 && Input::get('sickle_cell') == 1)
                        || (Input::get('cardiac') == 1 && Input::get('other') == 1)
                        || (Input::get('diabetes') == 1 && Input::get('sickle_cell') == 1)
                        || (Input::get('diabetes') == 1 && Input::get('other') == 1)
                        || (Input::get('sickle_cell') == 1 && Input::get('other') == 1)
                    ) {
                        $errorMessage = 'If Patient has Diagnosed with more than one Disease Please report before Proceeding ';
                    } elseif (Input::get('other') == 1 && empty(trim(Input::get('other_diseases')))) {
                        $errorMessage = 'Please add a valaue from question " Patient Diagnosis With any Other Diseases "Other " If Other Diseaes is "YES"" Before you submit again';
                    } elseif (Input::get('other') == 2 && !empty(trim(Input::get('other_diseases')))) {
                        $errorMessage = 'Please Remove a valaue from question " Patient Diagnosis With any Other Diseases "Other "" Before you submit again';
                    } elseif (Input::get('cardiac') == 2 && Input::get('diabetes') == 2 && Input::get('sickle_cell') == 2 && Input::get('other') == 2) {
                        $errorMessage = 'If Patient has Diagnosed without any Disease Please report before Proceeding ';
                    } else {
                        if ($main_diagnosis) {
                            $user->updateRecord('main_diagnosis', array(
                                'visit_date' => Input::get('diagnosis_date'),
                                'study_id' => $_GET['sid'],
                                'visit_code' => $_GET['vcode'],
                                'visit_day' => $_GET['vday'],
                                'seq_no' => $_GET['seq'],
                                'vid' => $_GET['vid'],
                                'cardiac' => Input::get('cardiac'),
                                'diabetes' => Input::get('diabetes'),
                                'sickle_cell' => Input::get('sickle_cell'),
                                'other' => Input::get('other'),
                                'other_diseases' => Input::get('other_diseases'),
                                'comments' => Input::get('comments'),
                                'patient_id' => $_GET['cid'],
                                'staff_id' => $user->data()->id,
                                'status' => 1,
                                'site_id' => $user->data()->site_id,
                            ), $main_diagnosis['id']);
                            $successMessage = 'Diagnosis Updated Successful';
                        } else {
                            $user->createRecord('main_diagnosis', array(
                                'visit_date' => Input::get('diagnosis_date'),
                                'study_id' => $_GET['sid'],
                                'visit_code' => $_GET['vcode'],
                                'visit_day' => $_GET['vday'],
                                'seq_no' => $_GET['seq'],
                                'vid' => $_GET['vid'],
                                'cardiac' => Input::get('cardiac'),
                                'diabetes' => Input::get('diabetes'),
                                'sickle_cell' => Input::get('sickle_cell'),
                                'other' => Input::get('other'),
                                'other_diseases' => Input::get('other_diseases'),
                                'comments' => Input::get('comments'),
                                'patient_id' => $_GET['cid'],
                                'staff_id' => $user->data()->id,
                                'status' => 1,
                                'created_on' => date('Y-m-d'),
                                'site_id' => $user->data()->site_id,
                            ));
                            $successMessage = 'Diagnosis added Successful';
                        }

                        $dignosis_type = '';

                        if (Input::get('cardiac') == 1) {
                            $dignosis_type = 1;
                        } else if (Input::get('diabetes') == 1) {
                            $dignosis_type = 2;
                        } else if (Input::get('sickle_cell') == 1) {
                            $dignosis_type = 3;
                        } else if (Input::get('other') == 1) {
                            $dignosis_type = 96;
                        } else if (Input::get('cardiac') == 0 && Input::get('diabetes') == 0 && Input::get('sickle_cell') == 0 && Input::get('other') == 0) {
                            $dignosis_type = 0;
                        } else {
                            $dignosis_type = 0;
                        }


                        $user->updateRecord('clients', array(
                            'cardiac' => Input::get('cardiac'),
                            'diabetes' => Input::get('diabetes'),
                            'sickle_cell' => Input::get('sickle_cell'),
                            'other' => Input::get('other'),
                            'other_diseases' => Input::get('other_diseases'),
                            'dignosis_type' => $dignosis_type
                        ), $_GET['cid']);

                        Redirect::to('info.php?id=7&cid=' . $_GET['cid'] . '&vid=' . $_GET['vid'] . '&vcode=' . $_GET['vcode'] . '&seq=' . $_GET['seq'] . '&sid=' . $_GET['sid'] . '&vday=' . $_GET['vday'] . '&status=' . $_GET['status'] . '&msg=' . $successMessage);
                        die;
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_summary')) {
            $validate = $validate->check($_POST, array(
                'summary_date' => array(
                    'required' => true,
                ),

            ));
            if ($validate->passed()) {
                try {

                    if (Input::get('visit_type') == 1) {
                        $visit_code = 'RV';
                        $visit_name = 'Registration Visit';
                    } elseif (Input::get('visit_type') == 2) {
                        $visit_code = 'SV';
                        $visit_name = 'Screening Visit';
                    } elseif (Input::get('visit_type') == 3) {
                        $visit_code = 'EV';
                        $visit_name = 'Enrollment Visit';
                    } elseif (Input::get('visit_type') == 4) {
                        $visit_code = 'FV';
                        $visit_name = 'Follow Up Visit';
                    } elseif (Input::get('visit_type') == 5) {
                        $visit_code = 'TV';
                        $visit_name = 'Study Termination Visit';
                    } elseif (Input::get('visit_type') == 6) {
                        $visit_code = 'UV';
                        $visit_name = 'Unschedule Visit';
                    }
                    $summary = $override->get3('summary', 'status', 1, 'patient_id', $_GET['cid'], 'seq_no', $_GET['seq']);
                    if ($summary) {
                        $user->updateRecord('summary', array(
                            'visit_date' => Input::get('summary_date'),
                            'summary_date' => Input::get('summary_date'),
                            'study_id' => $_GET['sid'],
                            'visit_code' => $_GET['vcode'],
                            'visit_day' => $_GET['vday'],
                            'seq_no' => $_GET['seq'],
                            'vid' => $_GET['vid'],
                            'visit_type' => Input::get('visit_type'),
                            'comments' => Input::get('comments'),
                            'diagnosis' => Input::get('diagnosis'),
                            'diagnosis_other' => Input::get('diagnosis_other'),
                            'outcome' => Input::get('outcome'),
                            'transfer_out' => Input::get('transfer_out'),
                            'transfer_out_date' => Input::get('transfer_out_date'),
                            'transfer_other' => Input::get('transfer_other'),
                            'cause_death' => Input::get('cause_death'),
                            'death_date' => Input::get('death_date'),
                            'death_other' => Input::get('death_other'),
                            'remarks' => Input::get('remarks'),
                            'set_next' => Input::get('set_next'),
                            'next_appointment_notes' => Input::get('next_appointment_notes'),
                            'next_appointment_date' => Input::get('next_appointment_date'),
                            'patient_id' => $_GET['cid'],
                            'staff_id' => $user->data()->id,
                            'status' => 1,
                            'site_id' => $user->data()->site_id,
                        ), $summary[0]['id']);

                        $summary_id = $override->get1('visit', 'status', 0, 'status', 1, 'client_id', $_GET['cid'], 'summary_id', $summary[0]['id']);

                        // if ($summary_id) {
                        //     $user->updateRecord('visit', array(
                        //         'summary_id' => $summary[0]['id'],
                        //         'expected_date' => Input::get('next_appointment_date'),
                        //         'summary_date' => Input::get('summary_date'),
                        //         'comments' => Input::get('comments'),
                        //         'diagnosis' => Input::get('diagnosis'),
                        //         'diagnosis_other' => Input::get('diagnosis_other'),
                        //         'outcome' => Input::get('outcome'),
                        //         'transfer_out' => Input::get('transfer_out'),
                        //         'transfer_other' => Input::get('transfer_other'),
                        //         'cause_death' => Input::get('cause_death'),
                        //         'death_other' => Input::get('death_other'),
                        //         'next_notes' => Input::get('next_appointment_notes'),
                        //     ),$summary_id[0]['id']);

                        // }else{
                        $seq_no = intval($_GET['seq']) + 1;

                        $visit_id = $override->get1('visit', 'status', 0, 'status', 1, 'client_id', $_GET['cid'], 'seq_no', $seq_no);

                        if ($visit_id) {
                            $user->updateRecord('visit', array(
                                'summary_id' => $summary[0]['id'],
                                'visit_code' => $visit_code,
                                'visit_name' => $visit_name,
                                'expected_date' => Input::get('next_appointment_date'),
                                'summary_date' => Input::get('summary_date'),
                                'comments' => Input::get('comments'),
                                'diagnosis' => Input::get('diagnosis'),
                                'diagnosis_other' => Input::get('diagnosis_other'),
                                'outcome' => Input::get('outcome'),
                                'transfer_out' => Input::get('transfer_out'),
                                'transfer_other' => Input::get('transfer_other'),
                                'cause_death' => Input::get('cause_death'),
                                'death_other' => Input::get('death_other'),
                                'next_notes' => Input::get('next_appointment_notes'),
                            ), $visit_id[0]['id']);
                        } else {
                            $last_visit = $override->getlastRow('visit', 'client_id', $_GET['cid'], 'id')[0];
                            $expected_date = $override->getNews('visit', 'expected_date', Input::get('next_appointment_date'), 'client_id', $_GET['cid'])[0];

                            $sq = $last_visit['seq_no'] + 1;
                            $visit_day = 'Day ' . $sq;

                            if (Input::get('set_next') == 1) {

                                $user->createRecord('visit', array(
                                    'summary_id' => $summary[0]['id'],
                                    'study_id' => $_GET['sid'],
                                    'visit_name' => $visit_name,
                                    'visit_code' => $visit_code,
                                    'visit_day' => $visit_day,
                                    'expected_date' => Input::get('next_appointment_date'),
                                    'visit_date' => '',

                                    'summary_date' => Input::get('summary_date'),
                                    'comments' => Input::get('comments'),
                                    'diagnosis' => Input::get('diagnosis'),
                                    'diagnosis_other' => Input::get('diagnosis_other'),
                                    'outcome' => Input::get('outcome'),
                                    'transfer_out' => Input::get('transfer_out'),
                                    // 'transfer_out_date' => Input::get('transfer_out_date'),
                                    'transfer_other' => Input::get('transfer_other'),
                                    'cause_death' => Input::get('cause_death'),
                                    // 'death_date' => Input::get('death_date'),
                                    'death_other' => Input::get('death_other'),
                                    'next_notes' => Input::get('next_appointment_notes'),

                                    'visit_window' => 0,
                                    'status' => 1,
                                    'client_id' => $_GET['cid'],
                                    'created_on' => date('Y-m-d'),
                                    'seq_no' => $sq,
                                    'reasons' => '',
                                    'visit_status' => 0,
                                    'site_id' => $user->data()->site_id,
                                ));
                            }
                        }

                        // }                       

                    } else {

                        $user->createRecord('summary', array(
                            'visit_date' => Input::get('summary_date'),
                            'summary_date' => Input::get('summary_date'),
                            'study_id' => $_GET['sid'],
                            'visit_code' => $_GET['vcode'],
                            'visit_day' => $_GET['vday'],
                            'seq_no' => $_GET['seq'],
                            'vid' => $_GET['vid'],
                            'visit_type' => Input::get('visit_type'),
                            'diagnosis' => Input::get('diagnosis'),
                            'diagnosis_other' => Input::get('diagnosis_other'),
                            'comments' => Input::get('comments'),
                            'outcome' => Input::get('outcome'),
                            'transfer_out' => Input::get('transfer_out'),
                            'transfer_out_date' => Input::get('transfer_out_date'),
                            'transfer_other' => Input::get('transfer_other'),
                            'cause_death' => Input::get('cause_death'),
                            'death_date' => Input::get('death_date'),
                            'death_other' => Input::get('death_other'),
                            'remarks' => Input::get('remarks'),
                            'set_next' => Input::get('set_next'),
                            'next_appointment_notes' => Input::get('next_appointment_notes'),
                            'next_appointment_date' => Input::get('next_appointment_date'),
                            'patient_id' => $_GET['cid'],
                            'staff_id' => $user->data()->id,
                            'status' => 1,
                            'created_on' => date('Y-m-d'),
                            'site_id' => $user->data()->site_id,
                        ));

                        $last_row = $override->lastRow('summary', 'id')[0];

                        //     // if ($expected_date['expected_date'] == Input::get('next_appointment_date')) {
                        //     //     $errorMessage = 'Next Date already exists';
                        //     // } else {

                        $seq_no = intval($_GET['seq']) + 1;

                        $visit_id = $override->get1('visit', 'status', 0, 'status', 1, 'client_id', $_GET['cid'], 'seq_no', $seq_no);

                        if ($visit_id) {
                            $user->updateRecord('visit', array(
                                'summary_id' => $last_row['id'],
                                'visit_code' => $visit_code,
                                'visit_name' => $visit_name,
                                'expected_date' => Input::get('next_appointment_date'),
                                'summary_date' => Input::get('summary_date'),
                                'comments' => Input::get('comments'),
                                'diagnosis' => Input::get('diagnosis'),
                                'diagnosis_other' => Input::get('diagnosis_other'),
                                'outcome' => Input::get('outcome'),
                                'transfer_out' => Input::get('transfer_out'),
                                'transfer_other' => Input::get('transfer_other'),
                                'cause_death' => Input::get('cause_death'),
                                'death_other' => Input::get('death_other'),
                                'next_notes' => Input::get('next_appointment_notes'),
                            ), $visit_id[0]['id']);
                        } else {
                            $last_visit = $override->getlastRow('visit', 'client_id', $_GET['cid'], 'id')[0];
                            $expected_date = $override->getNews('visit', 'expected_date', Input::get('next_appointment_date'), 'client_id', $_GET['cid'])[0];

                            $sq = intval($last_visit['seq_no']) + 1;
                            $visit_day = 'Day ' . $sq;

                            if (Input::get('set_next') == 1) {

                                $user->createRecord('visit', array(
                                    'summary_id' => $last_row['id'],
                                    'study_id' => $_GET['sid'],
                                    'visit_name' => $visit_name,
                                    'visit_code' => $visit_code,
                                    'visit_day' => $visit_day,
                                    'expected_date' => Input::get('next_appointment_date'),
                                    'visit_date' => '',

                                    'summary_date' => Input::get('summary_date'),
                                    'comments' => Input::get('comments'),
                                    'diagnosis' => Input::get('diagnosis'),
                                    'diagnosis_other' => Input::get('diagnosis_other'),
                                    'outcome' => Input::get('outcome'),
                                    'transfer_out' => Input::get('transfer_out'),
                                    // 'transfer_out_date' => Input::get('transfer_out_date'),
                                    'transfer_other' => Input::get('transfer_other'),
                                    'cause_death' => Input::get('cause_death'),
                                    // 'death_date' => Input::get('death_date'),
                                    'death_other' => Input::get('death_other'),
                                    'next_notes' => Input::get('next_appointment_notes'),

                                    'visit_window' => 0,
                                    'status' => 1,
                                    'client_id' => $_GET['cid'],
                                    'created_on' => date('Y-m-d'),
                                    'seq_no' => $sq,
                                    'reasons' => '',
                                    'visit_status' => 0,
                                    'site_id' => $user->data()->site_id,
                                ));
                            }
                        }

                        $successMessage = 'Schedule Summary  Added Successful';
                    }

                    if ($visit_name == 'Study Termination Visit') {
                        $user->updateRecord('clients', array(
                            'end_study' => 1,
                        ), $_GET['cid']);
                    } else {
                        $user->updateRecord('clients', array(
                            'end_study' => 0,
                        ), $_GET['cid']);
                    }

                    Redirect::to('info.php?id=7&cid=' . $_GET['cid'] . '&vid=' . $_GET['vid'] . '&vcode=' . $_GET['vcode'] . '&seq=' . $_GET['seq'] . '&sid=' . $_GET['sid'] . '&vday=' . $_GET['vday'] . '&status=' . $_GET['status'] . '&msg=' . $successMessage);
                    die;
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_region')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $regions = $override->get('regions', 'id', $_GET['region_id']);
                    if ($regions) {
                        $user->updateRecord('regions', array(
                            'name' => Input::get('name'),
                        ), $_GET['region_id']);
                        $successMessage = 'Region Successful Updated';
                    } else {
                        $user->createRecord('regions', array(
                            'name' => Input::get('name'),
                            'status' => 1,
                        ));
                        $successMessage = 'Region Successful Added';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_district')) {
            $validate = $validate->check($_POST, array(
                'region_id' => array(
                    'required' => true,
                ),
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $districts = $override->get('districts', 'id', $_GET['district_id']);
                    if ($districts) {
                        $user->updateRecord('districts', array(
                            'region_id' => $_GET['region_id'],
                            'name' => Input::get('name'),
                        ), $_GET['district_id']);
                        $successMessage = 'District Successful Updated';
                    } else {
                        $user->createRecord('districts', array(
                            'region_id' => Input::get('region_id'),
                            'name' => Input::get('name'),
                            'status' => 1,
                        ));
                        $successMessage = 'District Successful Added';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_ward')) {
            $validate = $validate->check($_POST, array(
                'region_id' => array(
                    'required' => true,
                ),
                'district_id' => array(
                    'required' => true,
                ),
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $wards = $override->get('wards', 'id', $_GET['ward_id']);
                    if ($wards) {
                        $user->updateRecord('wards', array(
                            'region_id' => $_GET['region_id'],
                            'district_id' => $_GET['district_id'],
                            'name' => Input::get('name'),
                        ), $_GET['ward_id']);
                        $successMessage = 'Ward Successful Updated';
                    } else {
                        $user->createRecord('wards', array(
                            'region_id' => Input::get('region_id'),
                            'district_id' => Input::get('district_id'),
                            'name' => Input::get('name'),
                            'status' => 1,
                        ));
                        $successMessage = 'Ward Successful Added';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        }
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
    <!-- <a href="#login" class="btn-get-started scrollto">Get Started</a>
        </div>
    </section> -->
    <!-- End Hero -->

    <main id="main">

        <!-- ======= Contact Section ======= -->
        <!-- ======= Contact Section ======= -->
        <section id="login" class="contact">
            <div class="container">

                <div class="section-title">
                    <h2>Back</h2>
                </div>
            </div>

            <!-- <div>
            <iframe style="border:0; width: 100%; height: 350px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" allowfullscreen></iframe>
        </div> -->

            <div class="container">
                <div class="row mt-5">
                    <?php
                    if ($_GET['disease'] == 1) {
                        $competencies = 'diabetes';
                    } elseif ($_GET['disease'] == 2) {
                        $competencies = 'cardiac';
                    } elseif ($_GET['disease'] == 3) {
                        $competencies = 'cardiac';
                    } elseif ($_GET['disease'] == 4) {
                        $competencies = 'cardiac';
                    } elseif ($_GET['disease'] == 5) {
                        $competencies = 'cardiac';
                    } elseif ($_GET['disease'] == 6) {
                        $competencies = 'cardiac';
                    } elseif ($_GET['disease'] == 7) {
                        $competencies = 'cardiac';
                    } elseif ($_GET['disease'] == 8) {
                        $competencies = 'cardiac';
                    }
                    ?>

                    <div class="col-lg-12 mt-5 mt-lg-0">
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

                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Add Mentoring For <?= $competencies ?></h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?disease=<?= $_GET['disease']; ?>">
                                            < Back</a>
                                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                </ol>
                            </div>
                        </div>
                        <hr>

                        <form method="post">
                            <?php
                            $logs = $override->getNews('logs', 'status', 1, 'id', $_GET['id'])[0];
                            $mentee = $override->getNews('user', 'status', 1, 'id', $logs['mentee'])[0];
                            $mentor = $override->getNews('user', 'status', 1, 'id', $logs['mentor'])[0];
                            $site = $override->getNews('site', 'status', 1, 'id', $logs['site_id'])[0];

                            ?>
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label>Visit Date </label>
                                    <hr>
                                    <input type="date" name="visit_date" class="form-control" id="visit_date" value="<?= $logs['visit_date']; ?>" placeholder="Visit Date" required>
                                </div>

                                <!-- <div class="col-md-3 form-group">
                                    <label>Number of Cases </label>
                                    <input type="number" name="cases" class="form-control" id="cases" value="<?= $logs['cases']; ?>" placeholder="Umber of Cases" required>
                                </div> -->
                                <div class="col-md-4 form-group">
                                    <label>Case ID</label>
                                    <hr>
                                    <input type="text" name="pids" class="form-control" id="pids" value="<?= $logs['pids']; ?>" placeholder="Case ID" required>
                                </div>
                                <div class="col-sm-4">
                                    <div class="row-form clearfix">
                                        <div class="form-group">
                                            <label>Site Name</label>
                                            <hr>
                                            <select class="form-control" name="site_id" style="width: 100%;" required>
                                                <option value="<?= $site['id'] ?>">
                                                    <?php if ($logs['site_id']) {
                                                        print_r($site['name']);
                                                    } else {
                                                        echo 'Select';
                                                    } ?>
                                                </option>
                                                <?php foreach ($override->get('site', 'status', 1) as $value) { ?>
                                                    <option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Competencies</label>
                                    <br>
                                    <hr>
                                    <!-- radio -->
                                    <div class="row-form clearfix">
                                        <div class="form-group">
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
                                            foreach ($override->get($competencies, 'status', 1) as $value) { ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="competencies[]" id="competencies<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php foreach (explode(',', $logs['competencies']) as $competency) {
                                                                                                                                                                                                    if ($competency == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    }
                                                                                                                                                                                                } ?>>
                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                </div>
                                                <br>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row-form clearfix">
                                        <div class="form-group">
                                            <label>Mentee Name</label>
                                            <hr>
                                            <select class="form-control" name="mentee" style="width: 100%;" required>
                                                <option value="<?= $mentee['id'] ?>">
                                                    <?php if ($logs['mentee']) {
                                                        print_r($mentee['firstname'] . ' ' . $mentee['lastname']);
                                                    } else {
                                                        echo 'Select';
                                                    } ?>
                                                </option>
                                                <?php foreach ($override->get('user', 'status', 1) as $value) { ?>
                                                    <option value="<?= $value['id']; ?>"><?= $value['firstname'] . ' ' . $value['lastname']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($logs) { ?>
                                    <div class="col-md-6 form-group">
                                        <label>Mentor Name</label>
                                        <hr>
                                        <input type="text" name="ment" class="form-control" value="<?= $mentor['firstname'] . ' ' . $mentor['lastname']; ?>" readonly>
                                    </div>
                                <?php } ?>

                            </div>

                            <hr>


                            <div class="col-md-12 form-group mt-3">
                                <label>Notes</label>
                                <textarea class="form-control" name="notes" rows="5" placeholder="Enter Notes Here" value="<?= $logs['notes']; ?>" required><?= $logs['notes']; ?></textarea>
                            </div>
                            <!-- <div class="my-3">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>
                            </div> -->
                            <hr>
                            <br>
                            <div class="col-4">
                                <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
                                <?php if ($user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) { ?>
                                    <input type="submit" value="Submit" name="add_logs" class="btn btn-primary btn-block">
                                <?php } ?>

                            </div>
                        </form>

                    </div>

                </div>

            </div>
        </section>
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