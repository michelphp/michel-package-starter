<?php

namespace Michel\Package;

use Psr\Container\ContainerInterface;

/**
 * Interface InstallablePackageInterface
 *
 * Implement this interface on packages that need to perform
 * installation tasks (create directories, add config files, etc.).
 *
 * This is optional: packages that don't need installation
 * should only implement PackageInterface.
 *
 * Called automatically by `php bin/michel package:init`.
 */
interface InstallablePackageInterface
{
    /**
     * Perform installation tasks for this package.
     *
     * @param ContainerInterface $container The service container (access project paths, config, etc.)
     * @param callable|null $output Optional callable for displaying messages to the user: $output('message')
     */
    public function install(ContainerInterface $container, ?callable $output = null): void;
}
