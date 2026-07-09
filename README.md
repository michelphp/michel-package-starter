# Michel Package Starter 🚀

This package provides the core interfaces needed to create and integrate packages into the **Michel Framework**. 

A Michel Package is a modular extension that hooks into the core application to register services, routes, commands, and listeners automatically. 

Keep it simple, keep it clean!

---

## 1. Installation

Install the starter via Composer in your package's repository:

```bash
composer require michel/michel-package-starter
```

---

## 2. The Core: `PackageInterface`

Every package must have a main class that implements `Michel\Package\PackageInterface`. This is where you declare everything your package provides to the framework.

```php
<?php

namespace MyCustomPackage;

use Michel\Package\PackageInterface;

final class MyPackage implements PackageInterface
{
    public function getDefinitions(): array
    {
        // 1. Register services (Dependency Injection)
        return [];
    }

    public function getParameters(): array
    {
        // 2. Provide default parameters
        return [];
    }

    public function getRoutes(): array
    {
        // 3. Define manual routes
        return [];
    }

    public function getControllerSources(): array
    {
        // 4. Register directories to scan for #[Route] attributes
        return [__DIR__ . '/Controller'];
    }

    public function getCommandSources(): array
    {
        // 5. Register console commands
        return [];
    }

    public function getListeners(): array
    {
        // 6. Register event listeners
        return [];
    }
}
```

---

## 3. Installation Hook (Optional): `InstallablePackageInterface`

If your package needs to perform setup tasks upon installation (like creating required directories, publishing assets, or configuring external resources), you should also implement the `InstallablePackageInterface`.

```php
<?php

namespace MyCustomPackage;

use Michel\Package\InstallablePackageInterface;
use Michel\Package\PackageInterface;
use Psr\Container\ContainerInterface;

final class MyPackage implements PackageInterface, InstallablePackageInterface
{
    // ... PackageInterface methods ...

    public function install(ContainerInterface $container, ?callable $output = null): void
    {
        $sessionDir = $container->get('michel.project_dir') . '/var/session';
        
        if (!is_dir($sessionDir)) {
            mkdir($sessionDir, 0755, true);
            if ($output) {
                $output('    ✔ Created: /var/session');
            }
        } else {
            if ($output) {
                $output('    – Already exists: /var/session');
            }
        }
    }
}
```

> **Note:** The `install()` method is triggered automatically by the framework when users run `composer require`, `composer install`, or manually via `php bin/michel package:init`. Always ensure your installation logic is **idempotent** (safe to execute multiple times).

---

## 4. Activation

To activate the package in a Michel project, the user simply adds it to their `config/packages.php` file, along with the environments where it should run:

```php
<?php
// config/packages.php

return [
    \MyCustomPackage\MyPackage::class => ['dev', 'prod'],
];
```

You are good to go!
