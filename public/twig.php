<?
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\ArrayLoader([
  'index' => 'Hello {{ name }}!',
]);
$twig = new \Twig\Environment($loader);

echo $twig->render('index', ['name' => 'Fabien']);




// $loader = new \Twig\Loader\FilesystemLoader('/path/to/templates');
// $twig = new \Twig\Environment($loader, [
//     'cache' => '/path/to/compilation_cache',
// ]);

// echo $twig->render('index.html', ['name' => 'Fabien']);
