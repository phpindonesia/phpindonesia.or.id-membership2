<?php
require 'bootstrap.php';

$db = $container['db'];

$users = $db->createQueryBuilder()
->select('username')
->from('users')
->setFirstResult(0)
->setMaxResults(5)
->orderBy('user_id', 'ASC')
->execute();

var_dump($users->fetchAll());
