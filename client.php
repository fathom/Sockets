#!/usr/bin/env php
<?php

$params = getopt('', [
	'address::', 
	'port::', 
	'message::'
]);

$address = $params['address'] ?? '127.0.0.1';
$port = $params['port'] ?? '9999';
$message = $params['message'] ?? 'GET /';

while (true) {
	usleep(1000000);

	$message = mt_rand(10000,99999);

	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

	if ($socket == false) {
		die('Socket create failed' . socket_strerror(socket_last_error()) . PHP_EOL);
	}

	$connect = socket_connect($socket, $address, $port);

	if ($connect == false) {
		die('Socket create failed' . socket_strerror(socket_last_error()) . PHP_EOL);
	}

	$message .= PHP_EOL;

	socket_write($socket, $message, strlen($message));

	$answer = '';
	$line = null;

	while($line !== '') {
		$line = socket_read($socket, 100);
		$answer .= $line;
	}

	echo $answer . PHP_EOL;

	socket_close($socket);
}
