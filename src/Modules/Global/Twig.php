<?php
namespace Mediashare\Modules;

class Twig
{
    public $cache = false; // Path to cache folder or false|null
    public $templates; // Path to templates folder
    public $twig;
    public function run() {
        $loader = new \Twig\Loader\FilesystemLoader('templates');
        if ($cache):
            $this->twig = new \Twig\Environment($loader, ['cache' => $this->cache]);
        else:
            $this->twig = new \Twig\Environment($loader);
        endif;
    }
    /**
     * Render view
     *
     * @param string $view
     * @param array|null $variables
     * @return twig->render()
     */
    public function render(string $view, ?array $variables) {
        return $this->twig->render($view, $variables);
    }
}
