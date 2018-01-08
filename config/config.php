<?php
/**
 * Created by IntelliJ IDEA.
 * User: lsm
 * Date: 07/01/18
 * Time: 21:49
 */


use App\Entity\User;

$container->loadFromExtension(
    'framework', array(
    'firewall_name' => 'secured_area',
    'csrf_protection' => true,
    'db_driver' => User::class,
));
