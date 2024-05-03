    <!-- ======= Contact Section ======= -->
    <section id="login" class="contact">
        <div class="container">

            <div class="section-title">
                <h2>Login</h2>
                <p>Please enter your credentials to Login.</p>
            </div>
        </div>

        <!-- <div>
            <iframe style="border:0; width: 100%; height: 350px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" allowfullscreen></iframe>
        </div> -->

        <div class="container">
            <div class="row mt-5">

                <!-- <div class="col-lg-4">
                    <div class="info">
                        <div class="address">
                            <i class="bi bi-geo-alt"></i>
                            <h4>Location:</h4>
                            <p>A108 Adam Street, New York, NY 535022</p>
                        </div>

                        <div class="email">
                            <i class="bi bi-envelope"></i>
                            <h4>Email:</h4>
                            <p>info@example.com</p>
                        </div>

                        <div class="phone">
                            <i class="bi bi-phone"></i>
                            <h4>Call:</h4>
                            <p>+1 5589 55488 55s</p>
                        </div>

                    </div>

                </div> -->

                <div class="col-lg-12 mt-5 mt-lg-0">

                    <form action="#" method="post" role="form" class="php-email-form">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>Visit Date </label>
                                <input type="date" name="visit_date" class="form-control" id="visit_date" placeholder="Visit Date" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Number of Cases </label>
                                <input type="number" name="visit_date" class="form-control" id="visit_date" placeholder="Umber of Cases" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Case ID</label>
                                <input type="text" name="visit_date" class="form-control" id="visit_date" placeholder="Case ID" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mt-3">
                                <label>Mentor Name</label>
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Mentor Name" required>
                            </div>
                            <div class="col-md-6 form-group mt-3">
                                <label>Mentee Name</label>
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Mentee Name" required>
                            </div>
                        </div>

                        <div class="col-md-12 form-group mt-3">
                            <label>Notes</label>
                            <textarea class="form-control" name="message" rows="5" placeholder="Notes" required></textarea>
                        </div>
                        <div class="my-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div>
                        <div class="col-4">
                            <input type="hidden" name="token" value="<?= Token::generate(); ?>">
                            <input type="submit" value="Submit" class="btn btn-primary btn-block">
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </section>
    <!-- End Contact Section -->