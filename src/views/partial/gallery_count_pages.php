<?php
$next = $current_page + 1;
$prev = $current_page - 1;
?>

<div class="page-count">
    <p>Strona: <?=$current_page?> z <?=$pages?></p>
    <?php if ($prev !== 0): ?>
    <a class="prev" href='/gallery?page=<?=$prev?>'>Poprzednia strona</a>
    <?php endif; ?>
    <?php if ($current_page < $pages): ?>
    <a class="next" href='/gallery?page=<?=$next?>'>Następna strona</a>
    <?php endif; ?>
</div>
