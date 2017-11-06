<?php
/**
 * Created by PhpStorm.
 * User: ndreux
 * Date: 25/10/2017
 * Time: 09:48
 */

$db = parse_url(getenv('CLEARDB_DATABASE_URL'));

$container->setParameter('database_driver', 'pdo_mysql');
$container->setParameter('database_host', $db['host']);
$container->setParameter('database_port', $db['port']);
$container->setParameter('database_name', substr($db["path"], 1));
$container->setParameter('database_user', $db['user']);
$container->setParameter('database_password', $db['pass']);
$container->setParameter('secret', getenv('SECRET'));
$container->setParameter('locale', 'en');
$container->setParameter('mailer_transport', "gmail");
$container->setParameter('mailer_host', null);
$container->setParameter('mailer_user', "nclsdrx@gmail.com");
$container->setParameter('mailer_password', "lkuzgrcnuqknrczg");
$container->setParameter('secret', 'ThisTokenIsNotSoSecretChangeIt');
$container->setParameter('cors_allow_origin', 'http://localhost');
$container->setParameter('varnish_urls', null);
$container->setParameter('jwt_private_key_path', '%kernel.root_dir%/../var/jwt/private_prod.pem');
$container->setParameter('jwt_public_key_path', '%kernel.root_dir%/../var/jwt/public_prod.pem');
$container->setParameter('jwt_key_pass_phrase', getenv('JWT_KEYS_PASS'));
$container->setParameter('jwt_token_ttl', 31536000);