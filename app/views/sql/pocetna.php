{@ DEFAULT @}

{{ CONTENT BEGIN }}
<h3>SQL test strana</h3>
<hr>
<?= $csrf ?>
<?php $start = microtime(true); ?>
<ul>
    <?php foreach ($data as $d) : ?>
        <li><?= e($d->first_name) . ' ' . e($d->last_name) ?>
            <ul>
                <?php foreach ($d->films() as $f) : ?>
                    <li><?= e($f->title) ?></li>
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
