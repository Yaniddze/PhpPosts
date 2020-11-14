<?php
require_once "./repositories/PostRepository.php";
require_once "./repositories/UserRepository.php";
require_once "CreateConnection.php";
$config = require_once "Config.php";

$postRepository = new PostRepository(CreateConnection($config));
$userRepository = new UserRepository(CreateConnection($config));
