<?php
/**
 * Created by IntelliJ IDEA.
 * User: lsm
 * Date: 07/01/18
 * Time: 21:32
 */

$container->loadFromExtension('monolog', array(
    'handlers' => array(
        'file_log' => array(
            'type'  => 'stream',
            'path'  => '%kernel.logs_dir%/%kernel.environment%.log',
            'level' => 'debug',
        ),
        'syslog_handler' => array(
            'type'  => 'syslog',
            'level' => 'error',
        ),
    ),
));