<?php if (isset($_SESSION['messages'])): ?>
    <div class="messages">
        <?php foreach ($_SESSION['messages'] as $type => $msg_array): ?>
            <div class="msg-<?= $type ?>">
                <ul>
                    <?php foreach ($msg_array as $msg): ?>
                        <li><?= $msg ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
<?php
unset($_SESSION['messages']);
endif;
?>