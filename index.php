<?php
// Front controller pour l'application MVC de gestion des courses familiales

// Inclusion des fichiers de configuration
require_once 'config/database.php';

// Fonction d'autoloading pour les classes
spl_autoload_register(function ($class_name) {
    $paths = [
        'app/models/',
        'app/controllers/',
        'app/views/'
    ];

    foreach ($paths as $path) {
        $file = $path . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Routage simple
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'achats';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = 'app/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerInstance = new $controllerName();

    if (method_exists($controllerInstance, $action)) {
        $controllerInstance->$action();
    } else {
        echo "Action non trouvée.";
    }
} else {
    echo "Contrôleur non trouvé.";
}
?>
