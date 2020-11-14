<?php
require_once "PostRepository.php";
require_once "CreateConnection.php";
$config = require_once "Config.php";

$postRepository = new PostRepository(CreateConnection($config));
