<section id="contactPage">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <br>
                <h1>Contact</h1>
                <?= $message !== null ? $this->alert($message) : null ?>
                <?= $form ?>
            </div>
        </div>
    </div>
</section>

