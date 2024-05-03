    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
        <div class="container">

            <div class="section-title">
                <h2>PEN-plus Mentoring Logbook</h2>
                <p>
                    This log book serves as a documentation tool used by the PEN-Plus provider in order to track encounters and application of key skills in PEN-Plus care post
                    training. Its principally designed to support learning and mentorship, and it is also linked to the patients identification system to facilitate quality case
                    management.
                </p>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                    <div class="icon-box">
                        <div class="icon"><i class="fas fa-heartbeat"></i></div>
                        <h4><a href="info.php?disease=1">Type 1/2
                                Diabetes</a></h4>
                        <p>Number of Records For this disease is <?= $override->getCount1('logs', 'status', 1, 'disease', 1) ?> in Tanzania Two Penplus Facility</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                    <div class="icon-box">
                        <div class="icon"><i class="fas fa-pills"></i></div>
                        <h4><a href="info.php?disease=2">Cardiac</a></h4>
                        <p>Number of Records For this disease is <?= $override->getCount1('logs', 'status', 1, 'disease', 2) ?> in Tanzania Two Penplus Facility</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0">
                    <div class="icon-box">
                        <div class="icon"><i class="fas fa-hospital-user"></i></div>
                        <h4><a href="info.php?disease=3">Sickle Cell Disease</a></h4>
                        <p>Number of Records For this disease is <?= $override->getCount1('logs', 'status', 1, 'disease', 3) ?> in Tanzania Two Penplus Facility</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
                    <div class="icon-box">
                        <div class="icon"><i class="fas fa-dna"></i></div>
                        <h4><a href="info.php?disease=4">Resp diseas</a></h4>
                        <p>Number of Records For this disease is <?= $override->getCount1('logs', 'status', 1, 'disease', 4) ?> in Tanzania Two Penplus Facility</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
                    <div class="icon-box">
                        <div class="icon"><i class="fas fa-wheelchair"></i></div>
                        <h4><a href="info.php?disease=5">Hypertension</a></h4>
                        <p>Number of Records For this disease is <?= $override->getCount1('logs', 'status', 1, 'disease', 5) ?> in Tanzania Two Penplus Facility</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
                    <div class="icon-box">
                        <div class="icon"><i class="fas fa-notes-medical"></i></div>
                        <h4><a href="info.php?disease=6">Epilepsy</a></h4>
                        <p>Number of Records For this disease is <?= $override->getCount1('logs', 'status', 1, 'disease', 6) ?> in Tanzania Two Penplus Facility</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
                    <div class="icon-box">
                        <div class="icon"><i class="fas fa-notes-medical"></i></div>
                        <h4><a href="info.php?disease=7">Liver</a></h4>
                        <p>Number of Records For this disease is <?= $override->getCount1('logs', 'status', 1, 'disease', 7) ?> in Tanzania Two Penplus Facility</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
                    <div class="icon-box">
                        <div class="icon"><i class="fas fa-notes-medical"></i></div>
                        <h4><a href="info.php?disease=7">Kidney</a></h4>
                        <p>Number of Records For this disease is <?= $override->getCount1('logs', 'status', 1, 'disease', 7) ?> in Tanzania Two Penplus Facility</p>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Services Section -->