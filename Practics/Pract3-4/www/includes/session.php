<?php
ini_set('session.save_handler', 'redis');
ini_set('session.save_path', 'tcp://redis:6379');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
