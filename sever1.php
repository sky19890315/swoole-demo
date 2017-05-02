<?php

	$server = new swoole_server('127.0.0.1', 9501);

	//配置进程数量
	$server->set([
		'task_worker_num' => 1,
	]);

	$server->on('Connect', function ($server, $fd) {
		echo "new client connect.".PHP_EOL;
	});

	$server->on('Receive', function ($server, $fd, $fromId, $data) {
		echo "worker received data: {$data}".PHP_EOL;


	//投递一个任务到task进程中
	$server->task($data);

	//通知客户端服务器接收到数据了
	$server->send($fd, 'This is a massage from service . if you see it, service receive data!');

	// 为了校验task是否是异步到，这里和task进程内都输出内容 看谁先输出
	echo 'worker continue run.'.PHP_EOL;

	});




/**
 * $serv swoole_server
 * $taskId 投递的任务id,因为task进程是由worker进程发起，所以多worker多task下，该值可能会相同
 * $fromId 来自那个worker进程的id
 * $data 要投递的任务数据
 */
	$server->on('Task', function ($server, $taskId, $fromId, $data) {
		echo "task start. -------from worker id: {$fromId}.".PHP_EOL;
		for ($i = 0; $i<5 ;$i++) {
			sleep(1);
			echo "task runing . ---- {$i}.".PHP_EOL;

		}
		//echo "task end.".PHP_EOL;
		return "task end.".PHP_EOL;
	});

/**
 * 只有在task进程中调用了finish 犯法或则会return了结果 才会触发finish
 */

$server->on('Finish', function ($server, $taskId, $data) {
	echo "finish received data {$data}".PHP_EOL;
});

$server->start();










