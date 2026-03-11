# Acorn User Roles

[![Packagist Downloads](https://img.shields.io/packagist/dt/roots/acorn-user-roles?label=downloads&colorB=2b3072&colorA=525ddc&style=flat-square)](https://packagist.org/packages/roots/acorn-user-roles)
[![Follow Roots](https://img.shields.io/badge/follow%20@rootswp-1da1f2?logo=twitter&logoColor=ffffff&message=&style=flat-square)](https://twitter.com/rootswp)
[![Sponsor Roots](https://img.shields.io/badge/sponsor%20roots-525ddc?logo=github&style=flat-square&logoColor=ffffff&message=)](https://github.com/sponsors/roots)

Simple user role management for Acorn.

## Support us

We're dedicated to pushing modern WordPress development forward through our open source projects, and we need your support to keep building. You can support our work by purchasing [Radicle](https://roots.io/radicle/), our recommended WordPress stack, or by [sponsoring us on GitHub](https://github.com/sponsors/roots). Every contribution directly helps us create better tools for the WordPress ecosystem.

## Requirements

- [PHP](https://secure.php.net/manual/en/install.php) >= 8.2
- [Acorn](https://github.com/roots/acorn) >= 5.0

## Installation

Install via Composer:

```bash
composer require roots/acorn-user-roles
```

## Getting Started

Start by optionally publishing the user-roles config:

```shell
$ wp acorn vendor:publish --provider="Roots\AcornUserRoles\AcornUserRolesServiceProvider"
```

## Usage

User roles can be configured in the published `config/user-roles.php` file.

### Adding a role

```php
'librarian' => [
    'display_name' => 'Librarian',
    'capabilities' => ['read', 'edit_books', 'publish_books'],
],
```

Capabilities can also be defined as an associative array:

```php
'editor_lite' => [
    'display_name' => 'Editor Lite',
    'capabilities' => [
        'read' => true,
        'edit_posts' => true,
        'delete_posts' => false,
    ],
],
```

### Removing a role

Since roles are stored in the database, removing a role from the config will not delete it. To remove a role, set it to `false`:

```php
'librarian' => false,
'subscriber' => false,
```

### Updating an existing role

Capabilities defined in config are synced on every request. If you change the capabilities or display name for an existing role, the configured values will be applied.

Capabilities not included in the config are left untouched, so capabilities added by other plugins are preserved. To explicitly deny a capability, set it to `false`:

```php
'editor' => [
    'capabilities' => [
        'read' => true,
        'edit_posts' => true,
        'delete_posts' => false, // explicitly denied
    ],
],
```

### Strict mode

If you want the config to be the single source of truth for a role, set `strict` to `true`. Any capabilities not listed in the config will be removed. In other words: `false` denies a listed capability, while `strict` removes unlisted capabilities.

```php
'editor' => [
    'strict' => true,
    'capabilities' => [
        'read' => true,
        'edit_posts' => true,
    ],
],
```

## Community

Keep track of development and community news.

- Join us on Discord by [sponsoring us on GitHub](https://github.com/sponsors/roots)
- Join us on [Roots Discourse](https://discourse.roots.io/)
- Follow [@rootswp on Twitter](https://twitter.com/rootswp)
- Follow the [Roots Blog](https://roots.io/blog/)
- Subscribe to the [Roots Newsletter](https://roots.io/subscribe/)
