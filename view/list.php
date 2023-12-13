<?php
global $items;
?>
<div>
    <?php foreach ($items as $itemKey => $item): ?>
    <h2><?= $itemKey ?></h2>
    <ul>
        <?php foreach ($item as $key => $value): ?>
        <li><?= $key ?>: <?= $value ?></li>
        <?php endforeach ?>
    </ul>
    <?php endforeach ?>
</div>