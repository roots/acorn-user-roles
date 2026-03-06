# Acorn User Roles

Simple user role management for Acorn.

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

```php
'subscriber' => false,
```

### Updating an existing role

Roles defined in config are kept in sync on every request. If you change the capabilities or display name for an existing role, the role will be updated to match.

## Bug Reports

If you discover a bug in Acorn User Roles, please [open an issue](https://github.com/roots/acorn-user-roles/issues).

## Contributing

Contributing whether it be through PRs, reporting an issue, or suggesting an idea is encouraged and appreciated.

## License

Acorn User Roles is provided under the [MIT License](LICENSE.md).
