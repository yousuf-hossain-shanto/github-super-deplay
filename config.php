<?php

$php_executable = 'php';
$composer_executable = realpath('./composer.phar');

$repositories = [
    'repository_name' => [
        'branch' => '',
        'local_dir' => '',
        'public' => true,
        'auth' => [             // If repo is private then github auth will needed
            'username' => '',
            'password' => '',
            'password_encription' => 'base64'
        ],
        'post_command' => "cd local_dir",
        'api_format' => 'https://github.com/{username}/{repository}/archive/{branch}.zip'
    ]
];