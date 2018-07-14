<!DOCTYPE html>
<html lang="sr">
    <head>
        <meta charset="utf-8">
        <?= $csrf_meta ?>
        <title><?= isset($naziv) ?: APP_NAME; ?></title>
        <link rel="stylesheet" type="text/css" href="<?= URL . '/css/normalize.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?= URL . '/css/skeleton.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?= URL . '/css/app.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?= URL . '/css/highlight/darcula.css'; ?>">
        <link rel="icon" href="<?= URL . '/favicon.ico'; ?>" type="image/x-icon">
    </head>

    <body>

        <div class="container">
            <header>
                <h1><a href="<?= $this->app->router->generate('get.pocetna') ?>" class="logo"><?= isset($naslov) ?: APP_NAME; ?></a></h1>
                <a href="<?= $this->app->router->generate('get.pocetna') ?>">Home</a> |
                <a href="<?= $this->app->router->generate('get.sql.test') ?>">SQL test</a> |
                <a href="https://mariadb.com/kb/en/" target="_blank">MariaDB</a> |
                <a href="http://www.mysqltutorial.org/" target="_blank">MySQL Tutorial</a>
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
        <script src="<?= URL . '/js/highlight.js'; ?>"></script>
        <script>hljs.initHighlightingOnLoad();</script>
    </body>

</html>


