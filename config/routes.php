<?php
/**
 * Created by IntelliJ IDEA.
 * User: lsm
 * Date: 04/01/18
 * Time: 22:32
 */

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;



$collection = new RouteCollection();
$collection->add('register', new Route('/register', array(
    '_controller' => 'App:Registration:register',
)));
$collection->add('logout', new Route('/logout', array(
    '_controller' => 'App:Security:logout',
)));
$collection->add('login', new Route('/login', array(
    '_controller' => 'App:Security:login',
)));
return $collection;