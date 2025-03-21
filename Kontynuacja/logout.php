<?php
session_start(); // Rozpocznij sesję

// Usuń wszystkie zmienne sesyjne
$_SESSION = array();

// Zniszcz sesję
session_destroy();

// Przekieruj do strony głównej
header("Location: index.php");
exit;
?>
