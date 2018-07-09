<?php

class Router {

    // Putanje aplikacije
    private $routes = [];
    // Putanje aplikacije sa imenom
    private $named_routes = [];
    // Putanja iz zahteva (deo sa imenima)
    private $request_route_name = null;
    // Cela putanja iz zahteva
    private $request_route = null;

    public function addRoutes($routes) {
        foreach ($routes as $route) {
            call_user_func_array(['Router', 'map'], $route);
        }
    }

    private function map($method, $route, $target, $name = null) {
        // TODO Proveriti da li je puanja konfliktna
        $this->routes[] = [$method, $route, $target, $name];
        if ($name) {
            if (isset($this->named_routes[$name])) {
                greska('Postoji putanja sa imenom:', $name);
            } else {
                $this->named_routes[$name] = $route;
            }
        }
    }

    public function match() {
        // Putanja iz zahteva (adresa)
        $request_uri = substr(SERVER['REQUEST_URI'], strlen(BASE));
        $this->request_route = URL . $request_uri;
        // Metoda iz zahteva (GET|POST)
        $request_method = SERVER['REQUEST_METHOD'];

        // Delovi putanje iz zahteva (delovi adrese)
        $request_uri_parts = explode('/', trim($request_uri, '/'));

        // Ako je prvi deo prazan onda je to osnovna putanja (/)
        if ($request_uri_parts[0] === '') {
            $request_uri_parts[0] = '/';
        }

        // Broj delova putanje iz zahteva
        $request_uri_parts_count = count($request_uri_parts);

        /*
         * Provera da li neka od putanja aplikacije odgovara putanji iz zahteva
         */
        foreach ($this->routes as $route) {

            // Promenjive iz putanje aplikacije
            list($method, $url, $action) = $route;

            // Ako metoda iz zahteva i metoda iz putanje aplikacije nisu iste preskoci
            if ($method !== $request_method) {
                continue;
            }

            // Delovi putanje aplikacije
            $url_parts = explode('/', trim($url, '/'));

            // Ako je prvi deo prazan onda je to osnovna putanja (/)
            if ($url_parts[0] === '') {
                $url_parts[0] = '/';
            }

            // Broj delova putanje aplikacije
            $url_parts_count = count($url_parts);

            // Niz sa delovima putanje aplikacije koji su naziv
            $url_name_parts = array_filter($url_parts, function ($part) {
                return (strpos($part, ':') === false);
            });

            // Broj delova putanje aplikacije koji su naziv
            $url_name_parts_count = count($url_name_parts);

            // Niz sa delovima putanje aplikacije koji su parametri (nazivi parametara)
            $url_params_parts = array_filter($url_parts, function ($part) {
                return (strpos($part, ':') !== false);
            });

            // Ciscenje naziva parametara
            $url_params_parts = str_replace(':', '', $url_params_parts);

            // Ako broj delova putanje iz zahteva i broj delova putanje aplikacije nije isti preskoci
            if ($request_uri_parts_count !== $url_parts_count) {
                $request_uri_name_parts = null;
                continue;
            } else { // Deljenje putanje iz zahteva na deo sa imenima i deo sa parametrima (vrednosti parametara)
                $request_uri_name_parts = array_slice($request_uri_parts, 0, $url_name_parts_count);
            }

            // Provera da li je deo sa imenima putanje iz zahteva isti sa delom sa imenima iz putanje aplikacije
            if ($request_uri_name_parts === $url_name_parts) {

                // Delovi putanje iz zahteva sa vrednostima parametara
                $request_uri_params_parts = array_slice($request_uri_parts, $url_name_parts_count);

                // Priprema niza za pokretanje kontrolera
                $params = array_combine($url_params_parts, $request_uri_params_parts);

                // Kontroler i metoda
                $controler_method = explode('#', $action);
                $controller = $controler_method[0];
                $function = $controler_method[1];

                $data = [
                    'method' => $method,
                    'controller' => $controller,
                    'action' => $function,
                    'params' => $params,
                ];
                $this->request_route_name = URL . '/' . implode('/', $request_uri_name_parts);
                return $data;
            }
        }
        greska('Nije pronađena putanja.', $request_uri);
    }

    public function generate($routeName, array $params = []) {
        if (!isset($this->named_routes[$routeName])) {
            greska('Ne postoji putanja sa tražnim imenom', $routeName);
        }

        $route = $this->named_routes[$routeName];
        $params_count = count($params);
        $route_parts = explode('/', trim($route, '/'));
        if ($route_parts[0] === '') {
            $route_parts[0] = '/';
        }

        $route_name_parts = array_filter($route_parts, function ($part) {
            return (strpos($part, ':') === false);
        });

        $route_params_parts = array_filter($route_parts, function ($part) {
            return (strpos($part, ':') !== false);
        });
        $route_params_parts_count = count($route_params_parts);

        if ($route_params_parts_count !== $params_count) {
            greska('Neodgovarajući broj parametara za putanju (' . $routeName . ')', "Prosleđeno: {$params_count} , očekuje {$route_params_parts_count}");
        }

        $url = URL . '/';
        if ($route_name_parts[0] !== '/' && count($route_name_parts) >= 1) {
            $url .= implode('/', $route_name_parts);
        }

        if ($route_params_parts_count > 0) {
            $url .= '/' . implode('/', $params);
        }

        return $url;
    }

    public function getCurrentUriName() {
        return $this->request_route_name;
    }

    public function getCurrentUri() {
        return $this->request_route;
    }

}
