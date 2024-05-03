    <!-- ======= Contact Section ======= -->
    <section id="login" class="contact">
        <div class="container">
            <div class="row mt-5">
                <section id="hero" class="d-flex align-items-center">
                    <div class="container">
                        <div class="col-lg-12 mt-2 mt-lg-0 text-center">
                            <h2>Please enter your credentials to Login.</h2>
                            <hr>

                            <form method="post">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <input type="text" name="username" class="form-control" id="username" placeholder="Your Username" required>
                                    </div>
                                    <div class="col-md-6 form-group mt-3 mt-md-0">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Your Password" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-center">
                                    <input type="hidden" name="token" value="<?= Token::generate(); ?>">
                                    <input type="submit" value="Sign in" class="btn btn-primary btn-block">
                                </div>
                            </form>

                        </div>
                    </div>
                </section>
            </div>

        </div>
    </section>
    <!-- End Contact Section -->