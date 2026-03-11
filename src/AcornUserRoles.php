<?php

namespace Roots\AcornUserRoles;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Roots\Acorn\Application;

class AcornUserRoles
{
    /**
     * The Application instance.
     */
    protected Application $app;

    /**
     * The user roles configuration.
     */
    protected Collection $config;

    /**
     * Built-in WordPress roles.
     */
    protected array $builtInRoles = [
        'administrator',
        'editor',
        'author',
        'contributor',
        'subscriber',
    ];

    /**
     * Create a new Acorn User Roles instance.
     *
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->config = Collection::make($this->app->config->get('user-roles'));

        $this->registerRoles();
    }

    /**
     * Make a new instance of Acorn User Roles.
     */
    public static function make(Application $app): self
    {
        return new static($app);
    }

    /**
     * Register, update, or remove user roles.
     */
    protected function registerRoles(): void
    {
        $this->config->each(function ($properties, $slug) {
            if ($properties === false) {
                $this->removeRole($slug);

                return;
            }

            if (! is_array($properties)) {
                $this->log("Invalid config for role '{$slug}': expected array or false, skipping");

                return;
            }

            $displayName = $properties['display_name'] ?? Str::headline($slug);
            $capabilities = isset($properties['capabilities'])
                ? $this->normalizeCapabilities($properties['capabilities'])
                : null;

            if (wp_roles()->is_role($slug)) {
                $this->syncRole($slug, $displayName, $capabilities);

                return;
            }

            add_role($slug, $displayName, $capabilities ?? ['read' => true]);
        });
    }

    /**
     * Remove a role if it exists.
     */
    protected function removeRole(string $slug): void
    {
        if (! wp_roles()->is_role($slug)) {
            return;
        }

        if (in_array($slug, $this->builtInRoles, true)) {
            $this->log("Removing built-in WordPress role: {$slug}");
        }

        remove_role($slug);
    }

    /**
     * Sync an existing role's display name and capabilities with config.
     */
    protected function syncRole(string $slug, string $displayName, ?array $capabilities): void
    {
        $role = get_role($slug);
        $wpRoles = wp_roles();

        if ($wpRoles->roles[$slug]['name'] !== $displayName) {
            $wpRoles->roles[$slug]['name'] = $displayName;
            update_option($wpRoles->role_key, $wpRoles->roles);
        }

        if ($capabilities === null) {
            return;
        }

        $isAdmin = $slug === 'administrator';
        $currentCaps = $role->capabilities;

        foreach ($capabilities as $cap => $granted) {
            if (! isset($currentCaps[$cap]) || $currentCaps[$cap] !== $granted) {
                if ($isAdmin) {
                    $this->log("Modifying administrator capability: {$cap}");
                }

                $role->add_cap($cap, $granted);
            }
        }
    }

    /**
     * Normalize capabilities to an associative array.
     */
    protected function normalizeCapabilities(array $capabilities): array
    {
        if (Arr::isAssoc($capabilities)) {
            return $capabilities;
        }

        return Collection::make($capabilities)
            ->mapWithKeys(fn ($cap) => [$cap => true])
            ->toArray();
    }

    /**
     * Log a warning message.
     */
    protected function log(string $message): void
    {
        $this->app->make('log')->warning("[acorn-user-roles] {$message}");
    }

    /**
     * Get the roles configuration.
     */
    public function getRoles(): Collection
    {
        return $this->config;
    }
}
