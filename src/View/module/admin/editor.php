<?php /** @var array $visibleArticles articles available to the wide public
        * @var array $hiddenArticles articles unavaialable to the wide public */ ?>

<h1 class="page-heading">Editor</h1>
<h2 class="page-heading">Select the article:</h2>
<form class="admin" method="GET">
    <label>Select an article:
        <select name="id_article_translated">
            <optgroup label="Visible Articles">
                <?php foreach ($visibleArticles as $article): ?>
                    <option value="<?= $article['id_article_translated'] ?>"><?= $article['title'] ?></option>
                <?php endforeach; ?>
            </optgroup>
            <optgroup label="Hidden Articles">
                <?php foreach ($hiddenArticles as $article): ?>
                    <option value="<?= $article['id_article_translated'] ?>"><?= $article['title'] ?></option>
                <?php endforeach; ?>
            </optgroup>
        </select>
    </label>
    
    <section class="buttons">
        <input name="select" class="approve standard-border" type="submit" value="Select" />
        <input name="Translate" class="approve standard-border" type="submit" value="Translate" disabled />
    </section>
</form>
<h2 class="page-heading">Editting: [<?= $toEdit['title'] ?? 'none' ?>]</h2>
<form class="admin" method="POST">
    <input name="id_article_translated" type="hidden" value="<?= $_POST['id_article_translated'] ?? $toEdit['id_article_translated'] ?? null ?>">
    <label>Title
        <textarea class="title" rows="3" type="text" name="title" maxlength="128" placeholder="" required><?= $_POST['title'] ?? $toEdit['title'] ?? null ?></textarea>
    </label>
    <!--<label>Image
        <select name="id_image">
            <?php foreach ($images ?? [] as $image): ?>
                <option <?= ($image['name'] === ($toEdit['name'] ?? 1)) ? 'selected="selected"' : null ?> value="<?= $image['id_image'] ?>"><?= $image['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </label>-->
    <label>Link
        <input class="link" type="text" name="link" maxlength="128" required value="<?= $_POST['link'] ?? $toEdit['link'] ?? null ?>" />
    </label>
    <label>Content
        <textarea rows="10" placeholder="Double click the text area to fit content!" ondblclick='this.style.height = "";this.style.height = this.scrollHeight + 10 + "px"' class="content" name="content" minlength="1000" maxlength="65535" required><?= $_POST['content'] ?? $toEdit['content'] ?? null ?></textarea>
    </label>
    <label>Digest
        <textarea placeholder="Ph'nglui mglw'nafh Cthulhu R'lyeh wgah'nagl fhtagn." rows="4" class="digest" name="digest" maxlength="100" required><?= $_POST['digest'] ?? $toEdit['digest'] ?? null ?></textarea>
    </label>
    <label>Keywords
        <input class="keywords" type="text" name="keywords" maxlength="255" required value="<?= $_POST['keywords'] ?? $toEdit['keywords'] ?? null ?>" />
    </label>
    <section class="buttons">
        <input name="save" class="approve standard-border" type="submit" value="Save" />
        <input name="delete" class="reject standard-border" type="submit" value="Delete" onclick="confirm('Are you sure?');" disabled />
    </section>
</form>