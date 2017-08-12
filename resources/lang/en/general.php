<?php

return [

    'text'              => [
        'welcome' 		=> 'e-Desk | Content Central',
		'home-header' 	=> 'DF17-APA',
        'newsstream'	=> 'New Stream',
        'newsfeed'  	=> 'News Feed',
    ],

    'button'              => [
        'cancel'            => 'Cancel',
        'close'             => 'Close',
        'save'              => 'Save',
        'create'            => 'Create',
        'delete'            => 'Delete',
        'clear'             => 'Clear',
        'edit'              => 'Edit',
        'ok'                => 'OK',
        'display'           => 'Show details',
        'replay'            => 'Replay',
        'update'            => 'Update',
        'enable'            => 'Enable user and send mail',
        'enabled'           => 'Enabled',
        'disable'           => 'Disable',
        'disabled'          => 'Disabled',
        'toggle-select'     => 'Toggle checkboxes',
        'remove-role'       => 'Remove role',
    ],

    'status'              => [
        'enabled'           => 'Enabled',
        'email-validated'   => 'You have successfully verified your account.',
        'profile'              => [
            'updated'             => 'Profile updated',
            'photo'         => [
                'update'          => 'Update Profile Picture',
                'updated'         => 'Profile photo updated',
            ],
        ],
        'enabled-and-mailed'   => 'User has been enabled and mailed to Join',
    ],

    'tabs'              => [
        'details'           => 'Details',
        'options'           => 'Options',
        'perms'             => 'Permissions',
        'users'             => 'Users',
        'roles'             => 'Roles',
        'routes'            => 'Routes',
        'data'              => 'Data',
        'profile'           => 'Profile',
        'settings'          => 'Settings',
        'pix'               => 'Picture',
    ],

    'error'              => [
        'title-403'             => 'Error 403',
        'title-404'             => 'Error 404',
        'title-500'             => 'Error 500',
        'description-403'       => '',
        'description-404'       => '',
        'description-500'       => '',
        'forbidden-403'         => 'Forbidden',
        'page-not-found-404'    => 'Page not found',
        'internal-error-500'    => 'Internal error',
        'client-error'          => 'Client error: :error-code',
        'server-error'          => 'Server error: :error-code',
        'what-is-this'          => 'What does this mean?',
        '403-explanation'       => 'The page or function that you tried to access is forbidden. The authorities have been contacted!',
        '404-explanation'       => 'The page or function that you are looking for could not be located. Try to go back to the previous page or select a new one.',
        '500-explanation'       => 'A serious problem occurred on the server, we will look at it ASAP and rectify the situation.',
        'error-proc-command'    => 'Error processing command: :cmd',
    ],

    'audit-log'           => [
        'category-login'               => 'Login',
        'category-register'            => 'Register',
        'category-profile'             => 'Profile',
        'msg-login-success'            => 'Successful login: :email.',
        'msg-login-failed'             => 'Login failed: :email.',
        'msg-forcing-logout'           => 'Forcing logout: :email.',
        'msg-registration-attempt'     => 'Registration attempt for :email.',
        'msg-account-created'          => 'Registration successful, account :email created.',
        'msg-email-validated'          => 'Email validated for: :email',
        'msg-account-enabled'          => 'Account :email enabled.',
        'msg-profile-show'             => 'Showing profile of: :email.',
        'msg-profile-update'           => 'Updating profile of: :email.',
        'enabled-and-emailed'          => 'User enabled and mailed to Join',
    ],

    'page'              => [
        'profile'              => [
            'title'             => 'User | Profile',
            'description'       => 'Displaying user: :full_name',
            'section-title'     => 'Profile details',
            'photo'             => [
                'title'         => 'User | Profile Picture',
                'description'   => 'Displaying user: :full_name',
                'section-title' => 'Photo details',
            ],
            'audit-log'       =>  [
                'category'      =>   'Profile picture update',
                'msg-profile-picture-show'     => 'User viewing profile picture',
                'msg-profile-picture-update'   => 'User profile picture updated'
            ],
        ],
    ],

];
