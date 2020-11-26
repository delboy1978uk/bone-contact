<?php
/** @var \Bone\Contact\Entity\Contact $message */

use Del\Icon;

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= Icon::SHIELD ?>&nbsp;&nbsp;Message Admin</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
                    <li class="breadcrumb-item"><a href="/admin/messages">Message Admin</a></li>
                    <li class="breadcrumb-item"><a href="/admin/messages/<?= $message->getId() ?>">Message View</a></li>
                    <li class="breadcrumb-item active">Message Reply</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- Main content -->
<section id="contactPage">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <br>
                <h1>Reply</h1>
                <?= $msg ? $msg : '<br>&nbsp;'?>
                <form class="form-horizontal">
                    <div class=" form-group row"><label for="" class="col-sm-2 col-md-3 control-label">To</label>
                        <div class="col"><?= $message->getName() ?></div>
                    </div>
                    <div class=" form-group row"><label for="" class="col-sm-2 col-md-3 control-label">Email</label>
                        <div class="col"><?= $message->getEmail() ?></div>
                    </div>
                    <div class=" form-group row"><label for="" class="col-sm-2 col-md-3 control-label">Tel</label>
                        <div class="col"><?= $message->getTelephone() ?></div>
                    </div>
                </form>
                <?= $form ?>
            </div>
        </div>
    </div>
</section>

