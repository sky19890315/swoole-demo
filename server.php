<?php
	//指定端口
	$server = new swoole_server('127.0.0.1', 9501);

	//开启两个进程
	$server->set([
		'worker_num'    => 2,
	]);

   //有新客户端连接时 进行反馈
	$server->on(
		'Connect', function ($server, $fd) {
		echo "new client connected." . PHP_EOL;
	}
	);

	//接收客户端数据并进行反馈

	$server->on('Receive', function ($server, $fd, $fromId, $data){
		//将接收到的数据返回给客户端
		$server->send($fd, 'From Server say:'.PHP_EOL.$data);
	});


	//客户端断开连接
	$server->on('Close', function ($server, $fd) {
		echo "Client close." . PHP_EOL;
	});


	$server->start();