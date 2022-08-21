<?php
namespace Deployer;

require 'vendor/deployer/recipes/recipe/rsync.php';

set('application', 'Resabilletcse');
set('ssh_multiplexing', true);

set('rsync_src', function () {
    return __DIR__;
});


add('rsync', [
    'exclude' => [
        '.git',
        '/.env',
        '/storage/',
        '/vendor/',
        '/node_modules/',
        '.github',
        'deploy.php',
    ],
]);

task('deploy:secrets', function () {
    file_put_contents(__DIR__ . '/.env', getenv('DOT_ENV'));
    upload('.env', get('deploy_path') . '/shared');
});

host('resabilletcse.tk')
    ->hostname('176.171.108.192')
    ->stage('staging')
    ->user('root')
    ->set('deploy_path', '/home/resabilletcse/htdocs/resabilletcse.tk');

host('new.resabilletcse.com')
    ->hostname('104.248.48.156')
    ->stage('production')
    ->user('root')
    ->set('deploy_path', '/var/www/new.resabilletcse.com');


after('deploy:failed', 'deploy:unlock');

desc('Deploy the application');

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'rsync',
    'deploy:secrets',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'artisan:storage:link',
    'artisan:view:cache',
    'artisan:config:cache',
    'artisan:migrate',
    'artisan:queue:restart',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);
