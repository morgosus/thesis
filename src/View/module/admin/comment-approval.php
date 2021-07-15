<?php if ($comments ?? false): ?>
    <h1 class="page-heading">Comment approval</h1>
    <form method="post">
        <?php foreach ($comments ?? [] as $sortedByArticle): ?>
            <h2 class="page-heading">Article: <?= $sortedByArticle[0]['title'] ?></h2>
            <?php foreach ($sortedByArticle ?? [] as $comment): ?>
                <section onclick="this.childNodes[1].checked === false ? this.childNodes[1].checked = true : this.childNodes[1].checked = false;" class="pending-comment standard-border<?= ($comment['duplicate']) ? ' duplicate' : null ?>">
                    <input class="checkbox-actual" name="id_comment[]" type="checkbox" value="<?= $comment['id_comment'] ?>" />
                    <section class="content">
                        <h3><?= $comment['name'] . ': ' ?></h3>
                        <div><?= $comment['content'] ?></div>
                    </section>
                </section>
            <?php endforeach; ?>
        <?php endforeach; ?>
        <section class="buttons">
            <input name="approve" class="approve standard-border" type="submit" value="Approve" />
            <input name="reject" class="reject standard-border" type="submit" value="Don't approve" />
        </section>
    </form>
<?php else: ?>
    <h1 class="page-heading">There are no comments left to approve</h1>
<?php endif; ?>