<!doctype html>
<html lang="pl">
<head>
    <?php require_once 'partial/default_head.php' ?>
    <title>Galeria</title>
</head>
<body>
<?php require 'partial/messages.php' ?>
<div class="main-container">
    <div class="nav-bar">
        <a href="/">Home</a>
    </div>
    <h1><i>Wyszukaj...</i></h1>
    <input type="text" name="q" size="90" onkeyup="getSuggestion(this.value)" autocomplete="off"/>
    </form>

    <?php
    if (count($images) !== 0): ?>
        <?php require_once 'partial/gallery_show_images.php'; ?>
    <?php else: ?>
        <div id="images">Zacznij wyszukiwać...</div>
    <?php endif; ?>
</div>

<script type="text/javascript">
    function getSuggestion(q){
        $.ajax({
            type: "GET",
            url: "/image_ajax",
            data: {title_part:q},
            success:function(data){
                $("#images").html(data);
            }
        });
    }
</script>
</body>
</html>