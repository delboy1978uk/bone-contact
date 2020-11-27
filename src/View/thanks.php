<?php

use Del\Icon;

?>
<section id="map" class="jumbotron text-center bg-white">
    &nbsp;
</section>
<br>&nbsp;<br>
<section>
    <div class="container">
        <h1>Contact The Lonergan Clinic</h1>
        <br>
        <div class="row">
            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">The Lonergan Clinic</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Where to find us</h6>
                        <p class="card-text"><?= Icon::HOME ?> 24 St Patrick's Ave <br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Curragh, Castlebar <br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Co. Mayo, F23 XH33 <br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ireland
                        </p>
                        <?= Icon::PHONE ?> 09490 60645 <br>
                        <?= Icon::ENVELOPE ?> <a href="mailto:info@thelonerganclinic.com">info@thelonerganclinic.com</a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <?= $message !== null ? $this->alert($message) : null ?>
                <p class="lead">Your email has been sent, and someone will be back in touch with you.</p>
            </div>
        </div>
        <br>
    </div>
</section>
