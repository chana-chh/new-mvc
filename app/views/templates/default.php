<!DOCTYPE html>
<html lang="sr">
    <head>
        <meta charset="utf-8">
        <title><?= isset($naziv) ?: APP_NAME; ?></title>
        <link rel="stylesheet" type="text/css" href="<?= URL . '/css/normalize.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?= URL . '/css/skeleton.css'; ?>">
        <link rel="icon" href="<?= URL . '/favicon.ico'; ?>" type="image/x-icon">
    </head>

    <body>

        <div class="container">
            <header>
                <h1><a href="<?= $this->app->router->generate('get.pocetna') ?>"><?= isset($naslov) ?: APP_NAME; ?></a></h1>
                <a href="<?= $this->app->router->generate('get.pocetna') ?>">Home</a> |
                <a href="<?= $this->app->router->generate('get.o-nama') ?>">About Us</a> |
                <a href="<?= $this->app->router->generate('get.kontakt') ?>">Contact</a> |
                <a href="<?= $this->app->router->generate('get.test', [1, 'Chana']) ?>">Test</a> |
                <a href="<?= $this->app->router->generate('get.sql', [1]) ?>">SQL</a>
            </header>

            <noscript>
            <h1 style="color: red;">This application requires javascript.</h1>
            </noscript>

            <div class="row">
                <div class="eight columns">
                    {{ CONTENT }}
                </div>
                <div class="four columns">
                    {{ ASIDE }}
                </div>
            </div>

            <footer>
                <p>Copyright &copy; <?= 'Chana - ' . date('Y'); ?></p>
            </footer>
        </div>

    </body>

</html>


