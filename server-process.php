<?php

$server = new swoole_server('127.0.0.1', 9501);

$server->set([
		'worker_num'        => 2,
		'task_worker_num'   => 1,
]);

$server->on('Connect', function ($server, $fd){});

$server->on('Receive', function ($server, $fd, $fromId, $data) {});

$server->on('Close', function ($server, $fd) {});

$server->on('Task', function ($server, $taskId, $fromId, $data) {});

$server->on('Finish', function ($server, $taskId, $data) {});

$server->start();

