<?php
include_once 'IRequest.php';

use \Twig\Extra\CssInliner\CssInlinerExtension;

class Request implements IRequest
{
    public $twig;
    public function __construct()
    {
        $this->bootstrapSelf();
    }

    private function bootstrapSelf()
    {
        $loader = new \Twig\Loader\FilesystemLoader();
        $loader->addPath('templates/student/', 'student');
        $loader->addPath('templates/admin/', 'admin');
        $loader->addPath('templates/about/', 'about');
        $loader->addPath('css/', 'css');
        $this->twig = new \Twig\Environment($loader);
        $this->twig->addExtension(new CssInlinerExtension());

        foreach ($_SERVER as $key => $value) {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    private function toCamelCase($string)
    {
        $result = strtolower($string);

        preg_match_all('/_[a-z]/', $result, $matches);

        foreach ($matches[0] as $match) {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }

    public function getBody()
    {
        if ($this->requestMethod == "POST") {
            $body = array();
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
            return $body;
        }
    }
}
