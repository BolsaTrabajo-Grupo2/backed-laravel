<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:BolsaTrabajo-Grupo2/backed-laravel.git');

set('git_tty', true);
add('shared_files', ['.env']);
add('shared_dirs', ['storage','bootstrap/cache']);
add('writable_dirs', ['storage','bootstrap/cache']);

host('18.208.14.230')
    ->set('remote_user','bolsa_user')
    ->set('identity_file','~/.ssh/id_rsa')
    ->set('deploy_path', '/var/www/proyecto-bolsa-laravel/html');

task('build', function () {
    run('cd {{release_path}} && build');
});

after('deploy:failed', 'deploy:unlock');

before('deploy:symlink', 'artisan:migrate');

