<?php
session_start();
session_destroy();
header("Location: login-test.php");
exit;
