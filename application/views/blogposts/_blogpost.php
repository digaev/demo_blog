<div class="blogpost">
    <h2><?= htmlspecialchars($blogpost->title()) ?></h2>
    <p class="text-muted">
        <a href="<?= base_url('blogposts/' . $blogpost->id()) ?>" title="<?= htmlspecialchars($blogpost->title()) ?>">#<?= $blogpost->id() ?></a>
        <span><?= date('F j Y \a\t H:i', $blogpost->created_at()) ?></span> by <a href="#"><?= htmlspecialchars($blogpost->user()->username()) ?></a>
    </p>
    <div class="text"><?= nl2br(htmlspecialchars($blogpost->body())) ?></div>
    <p class="text-info" align="right">
        <?php if ($this->session->is_logged): ?>
        <a href="#" class="like" data-blogpost-id="<?= $blogpost->id() ?>" title="Like"><i class="glyphicon glyphicon-thumbs-up"></i></a>
        <?php else: ?>
        <a href="#" class="like" title="Like (You must be logged in to access this feature)"><i class="glyphicon glyphicon-thumbs-up"></i></a>
        <?php endif ?>
        <span class="label label-primary">
            <span id="blogpost-points-<?=$blogpost->id() ?>"><?= $blogpost->likes() ?></span><span> likes</span>
        </span>
    </p>
</div>
