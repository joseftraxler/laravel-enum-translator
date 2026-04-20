<?php

declare(strict_types=1);

namespace Tests\Stubs;

use ArrayAccess;
use Illuminate\Contracts\Foundation\Application;

final class FakeApplication implements Application, ArrayAccess
{
    private array $instances = [];

    public function __construct()
    {
        $this->instances['app'] = $this;
        $this->instances[Application::class] = $this;
        $this->instances[\Illuminate\Contracts\Container\Container::class] = $this;
    }

    public function version()
    {
        // Unnecessary for tests
    }

    public function basePath($path = '')
    {
        // Unnecessary for tests
    }

    public function bootstrapPath($path = '')
    {
        // Unnecessary for tests
    }

    public function configPath($path = '')
    {
        // Unnecessary for tests
    }

    public function databasePath($path = '')
    {
        // Unnecessary for tests
    }

    public function langPath($path = '')
    {
        // Unnecessary for tests
    }

    public function publicPath($path = '')
    {
        // Unnecessary for tests
    }

    public function resourcePath($path = '')
    {
        // Unnecessary for tests
    }

    public function storagePath($path = '')
    {
        // Unnecessary for tests
    }

    public function environment(...$environments)
    {
        return count($environments) === 0 ? 'testing' : in_array('testing', $environments, true);
    }

    public function runningInConsole()
    {
        return true;
    }

    public function runningUnitTests()
    {
        return true;
    }

    public function hasDebugModeEnabled()
    {
        return true;
    }

    public function maintenanceMode()
    {
        return false;
    }

    public function isDownForMaintenance()
    {
        return false;
    }

    public function registerConfiguredProviders()
    {
    }

    public function register($provider, $force = false)
    {
        // Unnecessary for tests
    }

    public function registerDeferredProvider($provider, $service = null)
    {
        // Unnecessary for tests
    }

    public function resolveProvider($provider)
    {
        // Unnecessary for tests
    }

    public function boot()
    {
        // Unnecessary for tests
    }

    public function booting($callback)
    {
        // Unnecessary for tests
    }

    public function booted($callback)
    {
        // Unnecessary for tests
    }

    public function bootstrapWith(array $bootstrappers)
    {
        // Unnecessary for tests
    }

    public function getLocale()
    {
        return 'en';
    }

    public function getNamespace()
    {
        return '';
    }

    public function getProviders($provider)
    {
        return [];
    }

    public function hasBeenBootstrapped()
    {
        return true;
    }

    public function loadDeferredProviders()
    {
        // Unnecessary for tests
    }

    public function setLocale($locale)
    {
        // Unnecessary for tests
    }

    public function shouldSkipMiddleware()
    {
        return false;
    }

    public function terminating($callback)
    {
        // Unnecessary for tests
    }

    public function terminate()
    {
        // Unnecessary for tests
    }

    public function get(string $id)
    {
        return $this->make($id);
    }

    public function bound($abstract)
    {
        return $this->make($abstract);
    }

    public function alias($abstract, $alias)
    {
        // Unnecessary for tests
    }

    public function tag($abstracts, $tags)
    {
        // Unnecessary for tests
    }

    public function tagged($tag)
    {
        // Unnecessary for tests
    }

    public function bind($abstract, $concrete = null, $shared = false)
    {
        // Unnecessary for tests
    }

    public function bindMethod($method, $callback)
    {
        // Unnecessary for tests
    }

    public function bindIf($abstract, $concrete = null, $shared = false)
    {
        // Unnecessary for tests
    }

    public function singleton($abstract, $concrete = null)
    {
        // Unnecessary for tests
    }

    public function singletonIf($abstract, $concrete = null)
    {
        // Unnecessary for tests
    }

    public function scoped($abstract, $concrete = null)
    {
        // Unnecessary for tests
    }

    public function scopedIf($abstract, $concrete = null)
    {
        // Unnecessary for tests
    }

    public function extend($abstract, \Closure $closure)
    {
        // Unnecessary for tests
    }

    public function instance($abstract, $instance)
    {
        $this->instances[$abstract] = $instance;
    }

    public function addContextualBinding($concrete, $abstract, $implementation)
    {
        // Unnecessary for tests
    }

    public function when($concrete)
    {
        // Unnecessary for tests
    }

    public function factory($abstract)
    {
        // Unnecessary for tests
    }

    public function flush()
    {
        // Unnecessary for tests
    }

    public function make($abstract, array $parameters = [])
    {
        return $this->instances[$abstract]
            ?? throw new \RuntimeException("Failed to resolve {$abstract}");
    }

    public function call($callback, array $parameters = [], $defaultMethod = null)
    {
        // Unnecessary for tests
    }

    public function resolved($abstract)
    {
        return $this->make($abstract);
    }

    public function beforeResolving($abstract, ?\Closure $callback = null)
    {
        // Unnecessary for tests
    }

    public function resolving($abstract, ?\Closure $callback = null)
    {
        // Unnecessary for tests
    }

    public function afterResolving($abstract, ?\Closure $callback = null)
    {
        // Unnecessary for tests
    }

    public function has(string $id): bool
    {
        return isset($this->instances[$id]);
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->make($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->instance($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->instances[$offset]);
    }
}
