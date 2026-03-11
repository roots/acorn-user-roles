<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User Roles
    |--------------------------------------------------------------------------
    |
    | Define user roles to add or remove. Each key is the role slug.
    |
    | Set a role to `false` to remove it. Otherwise, provide an array with
    | `display_name` and `capabilities` to add or update the role.
    |
    | Capabilities can be a simple list (['read', 'edit_posts']) or an
    | associative array (['read' => true, 'edit_posts' => false]).
    |
    | Capabilities defined here are synced on every request. Capabilities
    | not listed are left untouched (e.g. those added by other plugins).
    |
    | Set `strict` to `true` on a role to make config authoritative —
    | any unlisted capabilities will be removed.
    |
    */

    // 'subscriber' => false,

    // 'librarian' => [
    //     'display_name' => 'Librarian',
    //     'capabilities' => ['read', 'edit_books', 'publish_books'],
    // ],

    // 'editor' => [
    //     'strict' => true,
    //     'capabilities' => [
    //         'read' => true,
    //         'edit_posts' => true,
    //     ],
    // ],

];
