<?php

session_start();
unset($_SESSION['statut']);
unset($_SESSION['user']);

session_destroy();

header('Location:index.php');

?>