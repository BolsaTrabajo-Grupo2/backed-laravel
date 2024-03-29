<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:BolsaTrabajo-Grupo2/backed-laravel.git');

set('git_tty', true);
set('composer_options' , '--ignore-platform-req=ext-mysql_xdevapi');
add('shared_files', ['.env']);
add('shared_dirs', ['storage','bootstrap/cache']);
add('writable_dirs', ['storage','bootstrap/cache']);

host('34.227.127.232')
    ->set('remote_user','bolsa_user')
    ->set('identity_file','~/.ssh/id_rsa')
    ->set('deploy_path', '/var/www/bolsa-trabajo/html');

task('build', function () {
    run('cd {{release_path}} && build');
});

after('deploy:failed', 'deploy:unlock');

before('deploy:symlink', 'artisan:migrate');
