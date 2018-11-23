#!/usr/bin/env bash

../vendor/bin/phpunit --bootstrap ../vendor/autoload.php amqp/*
../vendor/bin/phpunit --bootstrap ../vendor/autoload.php http_client/*
../vendor/bin/phpunit --bootstrap ../vendor/autoload.php websocket_client/*