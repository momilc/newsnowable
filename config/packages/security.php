<?php
/**
 * Created by IntelliJ IDEA.
 * User: lsm
 * Date: 07/01/18
 * Time: 21:34
 */

use App\Entity\User;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Csrf\CsrfTokenManager;

$container->loadFromExtension('security', array(
    'firewalls' => array(
        'secured_area'    => array(
            'pattern'     => '^/',
            'anonymous' => true,
            'simple_form' => array(
                'authenticator' => App\Security\TimeAuthenticator::class,
                'check_path'    => \Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface::class,
                'login_path'    => 'login',
                'default_target_path' => 'figure',
                'always_use_default_target_path' => true,
                'use_referer' => true,
            ),
        ),
    ),

    'access_control' => array(
        array('path' => '^/login$', 'role' => 'IS_AUTHENTICATED_ANONYMOUSLY'),
        array('path' => '^/logout', 'role' => 'IS_LOGOUT'),
        array('path' => '^/register', 'role' => 'IS_AUTHENTICATED_ANONYMOUSLY'),
        array('path' => '^/resetting', 'role' => 'IS_AUTHENTICATED_ANONYMOUSLY'),
        array('path' => '^/admin/users', 'role' => 'ROLE_SUPER_ADMIN'),
        array('path' => '^/admin', 'role' => 'ROLE_ADMIN'),
    ),

    'role_hierarchy' => array(
        'ROLE_ADMIN'       => 'ROLE_USER',
        'ROLE_SUPER_ADMIN' => array(
            'ROLE_ADMIN',
            'ROLE_ALLOWED_TO_SWITCH',
        ),
    ),

    'encoders' => array(
        User::class => array(
            'algorithm' => 'bcrypt',
            'cost' => 12,
        ),

    ),

    'providers' => array(
        'our_db_provider' => array(
            'entity' => array(
                'class'    => User::class,
                'property' => 'username',
            ),
        ),
    ),
    // ...
));

$container->setDefinition(CsrfTokenManager::class, new Definition(
    \App\Security\TimeAuthenticator::class,
    array(new Reference('doctrine.orm.entity_manager'))

));

$container->register(User::class)
    ->setArgument('$cachePool', new Reference('cache.app'))
    ->setPublic(false);

$container->register(User::class)
    ->setArguments(array(
        new Reference(TokenStorage::class),
        new Reference('security.authentication.manager'),
    ))
    ->setPublic(false);
