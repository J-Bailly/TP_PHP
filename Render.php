<?php
declare(strict_types=1);
require 'Classes/Autoloader.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Autoloader::register();

use tools\type\Text;
use tools\type\Hidden;
use tools\type\Textarea;
use tools\type\Checkbox;
use tools\type\Label;
use Provider\DataLoaderJson;
use View\Template;

$loader = new DataLoaderJson("Data/model.json");
$form = $loader->getData();

// ob_start();

$questions = [];

foreach($form as $field) {
    $className = 'tools\\type\\'.ucfirst($field['type']);
    // echo new $className($field['name'], $field['required']).PHP_EOL;
    $questions[] = (new $className($field['name'], $field['required'], $field['value']));
}

$action = $_REQUEST['action'] ?? false;

ob_start();
switch($action) {
    case 'submit':
        include 'Action/answer.php';
        break;
    default:
        include 'Action/form.php';
        break;
}

$content = ob_get_clean();

$template = new Template("Template");
$template->setLayout("main");
$template->setContent($content);

echo $template->compile();
?>