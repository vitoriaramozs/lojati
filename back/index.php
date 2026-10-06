<?php

require "config.php";

$rota = $_GET["rota"] ?? ($_SERVER["REQUEST_METHOD"] === "POST" ? "clientes" : "teste");

function teste() {
    echo "API respondendo com sucesso!";
}

function listarClientes($con){
    header("Content-Type: application/json; charset=utf-8");
    $stmt = $con->query("SELECT * FROM clientes");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function createClientes($con){
    $nome = $_POST["nome"] ?? "";
    $email = $_POST["email"] ?? "";
    $telefone = $_POST["telefone"] ?? "";
    $endereco = $_POST["endereco"] ?? "";
    $stmt = $con->prepare(
        "INSERT INTO clientes (Nome, Email, Telefone, Endereco)
         VALUES (?, ?, ?, ?)"
    );
    $stmt->execute([$nome, $email, $telefone, $endereco]);
    echo "Cliente cadastrado com sucesso!";
}

if ($rota === "listar/clientes") {
    listarClientes($con);
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    createClientes($con);
} else {
    teste();
}