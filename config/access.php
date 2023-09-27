<?php

return [


    /*
     * Configurations for the user
     */
    'users' => [

        /*
         * The name of the super administrator role
         */
        'admin_role' => 'Admin',
        'bu_role' => 'BU',
        'it_role' => 'IT',

        /*
         * The default role all new registered users get added to
         */
        'default_role' => 'user',

        /*
         * Login username to be used by the controller.
         */
        'username' => 'email',

    ],

    /*
    * Configuration for roles
    */
    'roles' => [
        /*
         * Whether a role must contain a permission or can be used standalone as a label
         */
        'role_must_contain_permission' => true,
    ],

    /*
     * Socialite session variable name
     * Contains the name of the currently logged in provider in the users session
     * Makes it so social logins can not change passwords, etc.
     */
    'socialite_session_name' => 'socialite_provider',
];
