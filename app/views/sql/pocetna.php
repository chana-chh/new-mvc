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
    <?php foreach ($data as $d) : ?>
        <li><?= e($d->naziv) . ' - ' . e($d->o2) ?></li>
    <?php endforeach; ?>
</ul>
<?php echo 'Vreme: ' . number_format(microtime(true) - $start, 3) . ' sec'; ?>
{{ CONTENT END }}

{{ ASIDE BEGIN }}
{! ASIDE !}
{{ ASIDE END }}


