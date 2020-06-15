<?php
require_once 'classes/Session.php';
Session::start();
Session::destroy();
header('location:index.php');