<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\Core;

use App\Libraries\TraceOps\Core\Contracts\ComponentDiscoveryInterface;
use App\Libraries\TraceOps\UI\BaseComponent;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use SplFileInfo;

final class ComponentDiscovery implements ComponentDiscoveryInterface
{
    /**
     * @return list<class-string<BaseComponent>>
     */
    public function discover(string $directory, string $namespace): array
    {
        if (! is_dir($directory)) {
            return [];
        }

        $directory = rtrim(str_replace('\\', '/', $directory), '/');
        $namespace = trim($namespace, '\\');
        $components = [];

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        /** @var SplFileInfo $file */
        foreach ($files as $file) {
            if (! $file->isFile() || strtolower($file->getExtension()) !== 'php') {
                continue;
            }

            $class = $this->className($directory, $namespace, $file->getPathname());

            if (! class_exists($class) || ! is_subclass_of($class, BaseComponent::class)) {
                continue;
            }

            $reflection = new ReflectionClass($class);

            if ($reflection->isAbstract()) {
                continue;
            }

            /** @var class-string<BaseComponent> $class */
            $components[] = $class;
        }

        sort($components);

        return array_values(array_unique($components));
    }

    private function className(string $directory, string $namespace, string $path): string
    {
        $path = str_replace('\\', '/', $path);
        $relativePath = substr($path, strlen($directory) + 1, -4);

        return $namespace . '\\' . str_replace('/', '\\', $relativePath);
    }
}
