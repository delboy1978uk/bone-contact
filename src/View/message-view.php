<?php
/** @var \Bone\Contact\Entity\Contact $message */

use Del\Icon;

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= Icon::SHIELD ?>&nbsp;&nbsp;Message View</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
                    <li class="breadcrumb-item"><a href="/admin/messages">Message Admin</a></li>
                    <li class="breadcrumb-item active">Message View</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="card card-primary card-outline">
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="mailbox-read-info">
                        <h5><?= $message->getSubject() ?></h5>
                        <h6>From: <?= $message->getName() ?> (<a href="mailto:<?= $message->getEmail() ?>"><?= $message->getEmail() ?></a>)
                            <span class="mailbox-read-time float-right"><?= $message->getDateReceived()->format('d M Y h:i A') ?></span></h6>
                    </div>
                    <!-- /.mailbox-controls -->
                    <div class="mailbox-read-message">
                            <p>
                                <?= nl2br($message->getMessage()) ?>
                            </p>
                    </div>
                    <!-- /.mailbox-read-message -->
                </div>
                <!-- /.card-body -->

                <!-- /.card-footer -->
                <div class="card-footer">
                    <div class="float-right">
                        <a href="/admin/messages/<?= $message->getId() ?>/reply" class="btn btn-success"><i class="fa fa-reply"></i> Reply</a>
                    </div>
                    <a href="/admin/messages/<?= $message->getId() ?>/delete" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
                </div>
                <!-- /.card-footer -->
            </div>
        </div>
    </div>
</section>
