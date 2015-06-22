<?php foreach ($blogposts as $blogpost): ?>
<div class="row blogposts">
    <div class="col-md-8 col-md-offset-2">
        <?php $this->view('blogposts/_blogpost.php', ['blogpost' => $blogpost]); ?>
    </div>
</div>
<?php endforeach ?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <?= $this->pagination->create_links() ?>
    </div>
</div>
