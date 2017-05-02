<?php
/**
 * 创建一个同步阻塞的TCP socket
 * 第一个参数表示socket 的类型 有以下这四种类型
 * 目前选择tcp sockect
 *
 * SWOOLE_SOCK_TCP 创建tcp socket
 * SWOOLE_SOCK_TCP6 创建tcp ipv6 socket
 * SWOOLE_SOCK_UDP 创建udp socket
 * SWOOLE_SOCK_UDP6 创建udp ipv6 socket
 * 第二个参数是同步还是异步
 * SWOOLE_SOCK_SYNC 同步客户端
 * SWOOLE_SOCK_ASYNC 异步客户端
 */


	$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_SYNC);

	//建立连接  如果失败 则直接退出并打出错误码
	$client->connect('127.0.0.1', 9501) || exit("connect failed. Error: {$client->errCode}\n");

	//向服务端发送数据
	$client->send('hello world');

	//从服务端接收数据
	$response = $client->recv();

	//输出接收到到数据
	echo $response.PHP_EOL;

	//关闭连接

	$client->close();

