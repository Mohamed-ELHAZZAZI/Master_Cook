<?php


config::set('site_name', 'Your site name');


config::set('routes', array (
    'default' => '',
    'admin' => 'admin_',
    'ajax' => 'ajax_',
    'print' => 'print_',
));

Config::set('default_route','default');
Config::set('default_controller','pages');
Config::set('default_action','index');


config::set('db.host', 'localhost');
config::set('db.user', 'root');
config::set('db.password', '');
config::set('db.db_name', 'db');