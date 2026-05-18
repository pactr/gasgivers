<?php
session_start();
session_unset();
session_destroy();
header('Location: /gasgivers/index.php');
exit();
