<?php

class View {

    private $app;

    public function __construct() {
        $this->app = App::instance();
    }

    public function render($view_path, $data = []) {
        // Promenjive za CSRF zastitu
        $csrf_meta = $this->app->csrf->metaTag();
        $csrf = $this->app->csrf->inputTag();
        // Prosledjivanje promenjivih
        extract($data);

        // Puna putanja do view fajla
        $full_view_path = DIR . 'app' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view_path . '.php';
        // popunjavanje sadrzaja view fajla
        if ($full_view_path) {
            ob_start();
            require_once $full_view_path;
            $content = ob_get_clean();
        } else {
            greska('Nije pronađen view fajl.', $full_view_path);
        }

        // Trazenje naziva templejta u sadrzaju view fajla
        $temp = getStringBetween($content, '{@', '@}');
        // Puna putanja do templejta
        $full_template_path = DIR . 'app/views/templates/' . trim(strtolower($temp)) . '.php';
        // Popunjavanje sadrzaja templejta
        if (file_exists($full_template_path)) {
            ob_start();
            require_once $full_template_path;
            $template = ob_get_clean();
        } else {
            greska('Nije pronađen template fajl.', $full_template_path);
        }

        // TODO Trazenje i ubacivanje include sadrzaja u tmplejt
        // Ovo da se pomeri kad je templejt popunjen blokovima pa onda
        // uraditi include tako da ce da odradi i u templejtu i u blokovima
        // Trazenje blokova u templejtu
        preg_match_all('#{{(.*)}}#', $template, $pm_template);
        // Niz blokova iz templejta
        $template_blocks = $pm_template[1];

        // Trazenje sadrzaja blokova u view fajlu
        $blocks = [];
        foreach ($template_blocks as $block) {
            $block_begin = '{{' . $block . 'BEGIN }}';
            $block_end = '{{' . $block . 'END }}';
            $rezultat = getStringBetween($content, $block_begin, $block_end);
            $blocks[$block] = $rezultat;
        }

        // Trazenje i ubacivanje include sardzaja u blokove
        foreach ($blocks as $key => $value) {
            preg_match_all('#{!(.*)!}#', $value, $pm_include);
            $tmp = $pm_include[1];
            if (!empty($tmp)) {
                foreach ($tmp as $inc) {
                    $include_file = DIR . 'app/views/inc/' . strtolower(trim($tmp[0])) . '.php';
                    // popunjavanje include
                    if (file_exists($include_file)) {
                        ob_start();
                        require_once $include_file;
                        $include = ob_get_clean();
                    } else {
                        greska('Nije pronađen include fajl.', $include_file);
                    }
                    $blocks[$key] = str_replace('{!' . $inc . '!}', $include, $value);
                }
            }
        }

        // zamena blokova sa sadrzajem
        $block_keys = array_map(function($e) {
            return '{{' . $e . '}}';
        }, array_keys($blocks));
        $block_values = array_values($blocks);
        $template = str_replace($block_keys, $block_values, $template);

        echo $template;
    }

}
