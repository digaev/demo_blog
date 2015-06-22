<div class="alert alert-<?= $type ?>">
    <?php if (isset($caption)): ?>
    <h4><?= $caption ?></h4>
    <?php endif ?>
    <?php if (isset($text)): ?>
    <?= $text ?>
    <?php endif ?>
</div>
