<?php
// login/services.php 
?>

<div id="services-panel" class="col-xl-8 col-lg-8 col-md-6 col-sm-12">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header">
            <h3 class="text-center my-2"><?= title() ?> Online Services</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="card mb-4">
                        <div class="card-header text-uppercase text-center font-weight-bold">
                            Document Tracking System
                        </div>

                        <div class="card-body">
                            <a href="<?= uri() . '/dts/track' ?>" title="Division Training Certificate Finder">Track</a> paper trail of documents created by schools, sections and offices within the schools division.
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header text-uppercase text-center font-weight-bold">
                            Personnel Information System
                        </div>

                        <div class="card-body">
                            Monitor individual details of teaching, teaching-related and non-teaching employees of the schools division.
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header text-uppercase text-center font-weight-bold">
                            Learning Resource Materials
                        </div>

                        <div class="card-body">
                            Quality assured educational and learning materials accessible through a dedicated learning resource <a href="https://sites.google.com/deped.gov.ph/sdodipologlrms/home" title="SDO Dipolog Learning Resource Portal" target="_blank">portal</a>.
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="card mb-4">
                        <div class="card-header text-uppercase text-center font-weight-bold">
                            Training Certificate Finder
                        </div>

                        <div class="card-body">
                            Access the <a href="<?= uri() . '/hrtdms/repository' ?>" title="Division Training Certificate Finder">repository</a> of participant certificates for training programs conducted by the schools division.
                        </div>
                    </div>

                    <?php require_once(root() . '/modules/calendar/page.php') ?>
                </div>
            </div>
        </div>
    </div>
</div>