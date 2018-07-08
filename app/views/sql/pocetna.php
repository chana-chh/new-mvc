{@ SQL @}


{{ CONTENT BEGIN }}
<h3>SQL test strana</h3>
<ul>
    <?php foreach ($rezultat as $data) : ?>
        <li>
            <?= $data->country ?>
            <ul>
                <?php foreach ($data->cities() as $city) : ?>
                    <li><?= $city->city ?></li>
                <?php endforeach; ?>
            </ul>
        </li>
    <?php endforeach; ?>
</ul>
{{ CONTENT END }}

{{ ASIDE BEGIN }}
<h3>Count</h3>
<p style="font-family: monospace;"><?= $broj ?></p>
<h3>Controller time</h3>
<p style="font-family: monospace;"><?= $vreme ?></p>
{{ ASIDE END }}
