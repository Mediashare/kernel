# Kernel
Mediashare Kernel with all public modules provided. 

```php
<?php
require 'vendor/autoload.php';
use Mediashare\Kernel\Kernel;

$kernel = new Kernel();
$kernel->run();
dump($kernel);
```