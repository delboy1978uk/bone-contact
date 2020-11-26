<?php

use Del\Icon;

?>
<section class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?= Icon::SHIELD ?>&nbsp;&nbsp;Message Admin</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
                    <li class="breadcrumb-item"><a href="/admin/messages">Message Admin</a></li>
                    <li class="breadcrumb-item active">Reply Sent</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="error-page">
        <h2 class="headline text-success"><?= Icon::PAPER_PLANE ?></h2>

        <div class="error-content">
            <h3><i class="fa fa-envelope text-success"></i> Reply successfully sent.</h3>
            <p class="intro-text">Your reply has been emailed, and a copy of your reply sent to your notification email address.</p>
             <a href="/admin/messages" class="btn btn-outline-success pull-right">Return to messages</a>
        </div>
    </div>
    <!-- /.error-page -->
    <br>&nbsp;
</section>
