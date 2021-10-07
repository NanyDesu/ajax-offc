<?php
$connect = mysqli_connect("127.0.0.1", "root", "");
if (!$connect) die("<h1>A conexão com o Banco de Dados falhou!</h1>");
$db = mysqli_select_db($connect, "pweb");