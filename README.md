# Kernel
**[DEPRECATED] Go to [Gitlab Project](https://gitlab.marquand.pro/MarquandT/kernel)**
Le kernel de Mediashare permet l'intégration simple des différentes libraries créer avec le [Modules Provider](http://slote.me/Libraries/modules-provider.html). [Kernel Documentation](https://mediashare.fr/Kernel/)

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
$hello->setMessage("Hello World\n")
$test = $hello->run();
```

### Cluster
Les clusters permettent l'automatisation de process avec la mise en file de modules qui s'éxécuteront via la function run() l'un à la suite de l'autre.
```php
<?php
require 'vendor/autoload.php';
use Mediashare\Kernel\Kernel;
use Mediashare\Kernel\Cluster;

$kernel = new Kernel();
$kernel->run();

// Using Cluster
$cluster = new Cluster(); // Create Cluster
$cluster->setModules([
    clone $kernel->get('Hello')->setMessage("[RUN] Git push \n"), // Echo
    clone $kernel->get('Git')->setMessage('CodeReview Cluster'), // Init message for commit
    clone $kernel->get('Hello')->setMessage("[END] Git push \n"), // Echo
]);
$cluster->run();
```
