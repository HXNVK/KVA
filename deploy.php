<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'https://github.com/HXNVK/KVA.git');

// Project name
set('application', 'kva');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('kva-test.helix-propeller.de')
    ->set('remote_user', 'kva')
    ->set('deploy_path', '/var/www/{{application}}');    


// Hooks
task('deploy:build', function() {
    cd('{{release_path}}');
    run('npm install');
    run('npm run prod');
});

after('deploy:failed', 'deploy:unlock');
after('artisan:migrate', 'deploy:build');
