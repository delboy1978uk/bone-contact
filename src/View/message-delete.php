<?php
/** @var \Bone\Contact\Entity\Contact $message */

use Del\Icon;

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= Icon::SHIELD ?>&nbsp;&nbsp;Message Delete</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
                    <li class="breadcrumb-item"><a href="/admin/messages">Message Admin</a></li>
                    <li class="breadcrumb-item"><a href="/admin/messages/<?= $message->getId() ?>">Message View</a></li>
                    <li class="breadcrumb-item active">Message Delete</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <?= $msg ?>
        <!-- Small boxes (Stat box) -->
        <div class="row justify-content-center">
            <?= $form ?>
        </div>
    </div>
</section>