<?php $this->layout($layout, ['title' => $title, 'siteUrl' => $siteUrl, 'logo' => $logo, 'address' => $address, 'unsubscribe' => null]) ?>
<div align="center" style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" class="padding">
    New message from <?= $data['asdfgh'] ;?>
</div>
<div align="center" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding">
    <table style="width: 100%">
        <?php
        foreach ($data as $key => $value) {
            echo '<tr><td>' . $key . '</td><td>' . $value .'</td></tr>';
        }
        ?>
    </table>
    <br>&nbsp;<br>
</div>