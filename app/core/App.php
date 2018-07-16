<?php

class App {
    // Putanje za automatsko ucitavanje klasa
    private $autoload_dirs = [];
    // Putanje aplikacije
    private $app_routes = [];
    // Trenutna putanja
    private $route = [];
    // Trenutni parametri
    private $params;
    // Dependency injection container
    private $dic;
    // Instanca klase za singlton
    private static $inst = null;

    public static function instance() {
        if (self::$inst === null) {
            self::$inst = new App();
        }
        return self::$inst;
    }

    private function __clone() {

    }

    public function setDic(DiC $dic) {
        $this->dic = $dic;
    }

    public function __get($name) {
        return $this->dic->$name;
    }

    public function get($name, $new = false) {
        return $this->dic->get($name, $new);
    }

    private function __construct() {
        $server = filter_input_array(INPUT_SERVER, FILTER_SANITIZE_STRING);
        define('SERVER', $server);
        $scheme = isset(SERVER['REQUEST_SCHEME']) ? SERVER['REQUEST_SCHEME'] : 'http';
        $url = $scheme . '://' . SERVER['HTTP_HOST'] . BASE;
        $url_admin = $scheme . '://' . SERVER['HTTP_HOST'] . BASE . ADMIN;

        // Zbog lakseg koriscenja definisu se konstante
        define('URL', $url);
        define('URL_ADMIN', $url_admin);

        // Priprema putanja za automatsko ucitavanje klasa
        if (defined('AUTOLOAD')) {
            $this->autoload_dirs = unserialize(AUTOLOAD);
        } else {
            greska('U konfiguracionom fajlu - nisu definisane putanje za automatsko učitavanje klasa.', 'app/config.php - AUTOLOAD');
        }

        // Registrovanje metode za automatsko ucitavanje klasa
        spl_autoload_register([$this, 'autoload']);

        // Ucitavanje fajla sa putanjama
        $rute = DIR . 'app/routes.php';
        if (is_readable($rute)) {
            require_once $rute;
        } else {
            greska('Nije pronađen fajl sa putanjama.', 'app/routes.php');
        }

        // Provera niza sa putanjama - rutama
        if (isset($routes) && is_array($routes)) {
            $this->app_routes = $routes;
        } else {
            greska('U fajlu sa putanjama nisu pravilno definisane putanje', 'app/routes.php - $routes');
        }
    }

    private function autoload($class_name) {
        $class = trim($class_name);

        foreach ($this->autoload_dirs as $dir) {
            $file = DIR . $dir . $class . '.php';
            if (is_readable($file)) {
                require_once $file;
                return true;
            }
        }

        greska('Nije pronađena klasa: ', $class_name);
    }

    public function run() {
        $this->router->addRoutes($this->app_routes);
        $route = $this->router->match();
        $this->dispatch($route);
    }

    private function dispatch($route) {
        $request_params = [];
        if (!empty($route['params'])) {
            // Preuzimanje parametara iz GET zahteva
            $request_params = sanitize($route['params']);
        } elseif ($route['method'] === 'POST') {
            // Preuzimanje parametara iz POST zahteva
            $request_params = [filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW)];
        }

        if (class_exists($route['controller'])) {
            $controller = new $route['controller'];
        } else {
            greska('Nije pronađen kontroler.', $route['controller']);
        }

        if (!method_exists($controller, $route['action'])) {
            greska('U kontroleru <code>' . $route['controller'] . '</code> nije pronađena metoda', $route['action']);
        }

        $this->route = $route;
        $this->params = isset($request_params[0]) ? $request_params[0] : [];

        call_user_func_array([$controller, 'csrf'], []);
        call_user_func_array([$controller, 'before'], []);
        call_user_func_array([$controller, $route['action']], $request_params);
        call_user_func_array([$controller, 'after'], []);
    }

    public function getRouteMethod() {
        return $this->route['method'];
    }

    public function getRequestParams() {
        return $this->params;
    }

}
