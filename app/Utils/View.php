<?php 

namespace App\Utils;

class View
{
    const file_404 = __DIR__ . '/../../resources/template/404.html';
    const file_template = __DIR__ . '/../../resources/template/template.html';
    const content_string = '{{content}}';

    private static function getContentView($view)
    {
        $file = __DIR__.'/../../resources/'. $view. '.html';
        $fileToShow = file_exists($file) ? $file : self::file_404;
        // $template = file_get_contents(self::file_header);
        $content = file_get_contents($fileToShow);

        return $content;
    }

    public static function render($view, $viewInfo = []) 
    {
        $templateView = str_replace(
            self::content_string, 
            self::getContentView($view), 
            file_get_contents(self::file_template)
        );

        $keys = array_keys($viewInfo);
        $keys = array_map(function($item){
            return '{{' . $item . '}}';
        },$keys);

        return str_replace($keys, array_values($viewInfo), $templateView);

    }
}
