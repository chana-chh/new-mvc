{@ DEFAULT @}

{{ CONTENT BEGIN }}
<h3>Prijava korisnika</h3>
<form action="" method="POST">
    <?= $csrf ?>
    <input type="text" name="korisnik">
    <input type="submit" name="submit" value="Submit" class="button button-primary">
</form>
{{ CONTENT END }}

{{ ASIDE BEGIN }}
{! ASIDE !}
{{ ASIDE END }}
