<?php
session_start();

include "conexao.php";


switch ($_GET['a']) {
    case 'cadastrar':
            // Fluxo de criação de tarefas
           
            if(isset($_POST['tarefa'])){

                $titulo_tarefa= $_POST['tarefa'];
                $descricao_tarefa= $_POST['descricao'];
                $status_tarefa= $_POST['status'];
                $prazo_tarefa= $_POST['prazo'];

                $sql = "INSERT INTO tarefas (nome, descricao, status, prazo)
                        VALUES (:nome, :descricao, :status, :prazo)";
                
                $execucao = $pdo->prepare($sql);

                $execucao->execute([':nome' => $titulo_tarefa ,
                     ':descricao' => $descricao_tarefa,
                     ':prazo' => $prazo_tarefa,
                    ':status' => $status_tarefa]);

             // echo 'Tarefa criada com sucesso: ' . $pdo->lastInsertId();
            //  exit();

            }
            

            header("Location: /crud/index.php ");
            exit; 
        break;
    case 'deletar':
        
        $qual = $_GET['id'];
       
        $sql = "DELETE FROM tarefas WHERE id = $qual";
        
        $execucao = $pdo->query($sql);

        header("Location: /crud/index.php ");

        break;
    case 'editar':
        $tarefa = $_GET['id'];
        $nome_tarefa = $_POST['nome'];
        $descricao_tarefa = $_POST['descricao'];
        $status_tarefa = $_POST['status'];
        $prazo_tarefa = $_POST['prazo'];

        $sql = "UPDATE tarefas
                SET nome = :nome, descricao = :descricao, status = :status,
                prazo = :prazo
                WHERE id = :id";

        $preparacao = $pdo->prepare($sql);

        $executa = $preparacao->execute([':nome' => $nome_tarefa,
         ':id' => $tarefa ,
         ':prazo' => $prazo_tarefa,
         ':status' => $status_tarefa,
        ':descricao' => $descricao_tarefa]);

        header("Location: /crud/index.php ");

        break;
    default:
        # code...
        break;
}


