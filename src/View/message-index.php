<?php
/** @var \Bone\Contact\Entity\Contact[] $messages */

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
                    <li class="breadcrumb-item active">Message Admin</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="row">
    <div class="col"><?= $paginator ?></div>
</div>


<div class="row">
    <div class="col-12">
        <div class="">
            <!-- /.card-header -->
            <div class="card card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th>Date Received</th>
                        <th>Name</th>
                        <th>Subject</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (count($messages)) {
                        foreach ($messages as $message) { ?>
                            <tr>
                                <td><?= $message->getDateReceived()->format('d M Y H:i') ?></td>
                                <td><?= $message->getName() ?></td>
                                <td><?= $message->getSubject() ?></td>
                                <td><a class="tt" title="view" href="/admin/messages/<?= $message->getId() ?>"><?= Icon::EYE ;?></a>
                                    <a class="tt" title="delete" href="/admin/messages/<?= $message->getId() ?>/delete"><?= Icon::REMOVE ;?></a></td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="5" class="text-danger">No messages have been found in the database.</td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
