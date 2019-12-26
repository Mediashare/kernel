# Kernel
Le kernel de Mediashare permet l'intégration simple des différentes libraries créer avec le [Modules Provider](http://slote.me/Libraries/modules-provider.html).

## Installation
```bash
composer require mediashare/kernel
```
## Usage
```php
<?php
require 'vendor/autoload.php';
use Mediashare\Kernel\Kernel;

$kernel = new Kernel();
$kernel->run();
dump($kernel);
```
```$kernel``` retourne l'objet Kernel avec la liste des modules initiés.
### Get Module from Kernel
```php
<?php
require 'vendor/autoload.php';
use Mediashare\Kernel\Kernel;

$kernel = new Kernel();
$kernel->run();

$hello = $kernel->get('Hello');
$test = $hello->echo("Test \n");
```