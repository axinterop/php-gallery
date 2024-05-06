<div class="images" id="images">
    <?php foreach ($images as $img): ?>
        <div style="float: left; border: 1px solid black; margin: 5px; padding: 5px">
            <a href="<?= $img['path_no_ext'] . '-wm.png' ?>">
                <img src="<?= $img['path_no_ext'] . '-min.jpeg' ?>">
            </a>
            <p>Tytuł: <?= $img['title'] ?></p>
            <p>Autor: <?= $img['author'] ?></p>
            <p>
                <?php if ($img['private']): ?>
                <span class="img-private">Prywatne</span>
                <?php else: ?>
                <span class="img-public">Publiczne</span>
                <?php endif; ?>
            </p>
            <?php if (isset($img_memory)): ?>
            <input class="remembered_images" type="checkbox" name="images[]" value="<?= $img['_id'] ?>"
                   form="rem_img_form"
                <?php if (in_array($img['_id'], $img_memory)) echo "checked" ?>>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
