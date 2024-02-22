<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:BolsaTrabajo-Grupo2/backed-laravel.git');

set('git_tty', true);
set('composer_options' , '--ignore-platform-req=ext-mysql_xdevapi');
add('shared_files', ['.env', 'docker-compose.yml']);
add('shared_dirs', ['storage','bootstrap/cache']);
add('writable_dirs', ['storage','bootstrap/cache']);

host('35.172.75.164')
    ->set('remote_user','bolsa_user')
    ->set('identity_file','~/.ssh/id_rsa')
    ->set('deploy_path', '/var/www/bolsa-trabajo/html');

task('build', function () {
    run('cd {{release_path}} && build');
});

after('deploy:failed', 'deploy:unlock');

before('deploy:symlink', 'artisan:migrate');
