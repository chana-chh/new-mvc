{@ DEFAULT @}

{{ CONTENT BEGIN }}
<h3>SQL test strana</h3>
<hr>

<form action="" method="POST">
    <?= $csrf ?>
    <input type="text" name="korisnik">
    <input type="submit" name="submit" value="Submit" class="button button-primary">
</form>
<hr>
<?php $start = microtime(true); ?>
<ul>
    <?php foreach ($data as $f) : ?>
        <li><?= e($f->title) ?>
            <ul>
                <?php foreach ($f->actors() as $a) : ?>
                    <li><?= e($a->first_name . ' ' . $a->last_name) ?></li>
                <?php endforeach; ?>
            </ul>
        </li>
    <?php endforeach; ?>
</ul>
<?php echo 'Vreme: ' . (microtime(true) - $start) . ' sec'; ?>
{{ CONTENT END }}

{{ ASIDE BEGIN }}
{! ASIDE !}
{{ ASIDE END }}
