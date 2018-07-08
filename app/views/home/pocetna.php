{@ DEFAULT @}


{{ CONTENT BEGIN }}
<h3>Zaposleni u kancelariji 311</h3>
<?= '<h5><a href="' . $this->app->router->generate('get.test', [2, 'Chana']) . '">Test strana</a></h5>'; ?>
<ul>
    <?php foreach ($data311 as $zap) : ?>
        <li><?= $zap; ?></li>
    <?php endforeach; ?>
</ul>
{{ CONTENT END }}

{{ ASIDE BEGIN }}
<h3>Dodatak</h3>
{{ ASIDE END }}
