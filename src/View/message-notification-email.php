<?php
/** @var \Bone\Contact\Entity\Contact $message */
$this->layout($layout, ['title' => $title, 'siteUrl' => $siteUrl, 'logo' => $logo, 'address' => $address, 'unsubscribe' => null]) ?>
<div align="center" style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" class="padding">
   You sent a reply to <?= $message->getName() ;?>
</div>
<div align="center" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding">
    <table style="width: 100%">
        <tr><td>Name</td><td><?= $message->getName() ?></td></tr>
        <tr><td>Email</td><td><?= $message->getEmail() ?></td></tr>
        <tr><td>Telephone</td><td><?= $message->getTelephone() ?></td></tr>
        <tr><td>Subject</td><td><?= $message->getSubject() ?></td></tr>
        <tr><td>Original Message</td><td><?= nl2br($message->getMessage()) ?></td></tr>
    </table>
</div>
<div style="text-align: left; font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333; " class="padding">
    <p>You sent a the following reply:</p>
    <p><strong><?= $data['subject'] ?></strong></p>
    <p><?= nl2br($data['message']) ?></p>
</div>