<?php
session_start();
include "conexao.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Tarefas </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    
    <h1>Cadastro de Tarefas</h1>
    <div class="container">
       
        <?php 
        if(!isset($_GET['editar'])){
          
        ?>
        <form action="/crud/acao.php?a=cadastrar" method="post">
            <div class="mb-3">
                    <label class="form-label">
                       Status da tarefa (nova)
                    </label> <br>
                    <select name="status" required>
                        <option value="" disabled selected>Selecione...</option>
                        <option value="pendente">Pendente</option>
                        <option value="em_execucao">Em execução</option>
                        <option value="concluida">Concluída</option>
                    </select>
                    <hr>
                    <label class="form-label">
                        Nome da tarefa (nova)
                    </label>
                    <input type="text" class="form-control" name="tarefa" 
                    placeholder="Informe a tarefa" required>
                    <hr>
                    <label for="">Prazo</label>
                    <input type="datetime-local" class="form-control"  name="prazo"><br><br>
                    <hr>
                     <label class="form-label">
                       Descrição
                    </label>
                   <textarea name="descricao" id="" class="form-control"></textarea>
                </div>   
                <hr>
                <input type="submit" value="Cadastrar">             
                </div>
        </form>

        <?php 
        }else{
            $tarefa = $_GET['editar']; 

            $sql = "SELECT * FROM tarefas WHERE id = $tarefa";
            $execucao = $pdo->query($sql);
            $tarefas =  $execucao->fetchAll(PDO::FETCH_ASSOC);
            foreach ($tarefas as $key => $value) { 

        ?>
        <form action="/crud/acao.php?a=editar&id=<?php echo $tarefa; ?>" method="post">
            <div class="mb-3">
                 <label class="form-label">
                       Status da tarefa (nova)
                    </label> <br>
                    <select name="status" required>
                        <option value="" disabled >Selecione...</option>
                        <option value="pendente" <?php if($value['status'] == 'pendente'){ echo 'selected';}?>>Pendente</option>
                        <option value="em_execucao" <?php if($value['status'] == 'em_execucao'){ echo 'selected';}?>>Em execução</option>
                        <option value="concluida" <?php if($value['status'] == 'concluida'){ echo 'selected';}?>>Concluída</option>
                    </select>
                    <hr>
                    
                <label class="form-label">
                    Nome da tarefa (Editar)
                </label>
                <input type="text" class="form-control" name="nome" 
                 placeholder="Informe a tarefa" required
                 value="<?php echo  $value['nome']; ?>">
                </div> 
                <label for="">Prazo</label>
                <input type="datetime-local" class="form-control" 
                    value="<?php echo $value['prazo']?>" 
                     name="prazo"><br><br>
                <hr> 
                <label class="form-label">
                    Descrição da tarefa (Editar)
                </label> 
                <textarea class="form-control" name="descricao" id=""><?php echo  $value['descricao']; ?></textarea>
                <hr>
                <input type="submit" value="Salvar">             
            </div>
        </form>
            <?php 
            } // aqui finaliza o Foreach
    } // aqui finaliza o IF de editar ?>
    </div>
    <hr>
    <div class="container">
        <h2>Lista de tarefas</h2>
        <form action="/crud/index.php?a=buscar">
            <input type="text" placeholder="Buscar...">
            <input type="submit" value="Buscar">
        </form>
        <table class="table table-striped"> 
            <thead>
                <tr>
                <th scope="col">#</th> 
                <th scope="col">Nome - Evandro</th>
                <th scope="col">Descrição</th>
                <th scope="col">Prazo</th>
                <th scope="col">Status</th> 
                <th>Ações</th>
                </tr>
            </thead>  
            <tbody>

                <?php 

                    
                    $sql = "SELECT * FROM tarefas ORDER BY id DESC";
                    $execucao = $pdo->query($sql);
                    $tarefas =  $execucao->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($tarefas as $key => $value) {  
                        
                        switch ($value['status']) {
                            case 'em_andamento':
                                $tipo_linha = "table-warning";
                                break;
                            case 'concluida':
                                $tipo_linha = "table-success";
                                break;
                            case 'pendente':
                                $tipo_linha = "table-danger";
                            break;
                        }
                ?>
                <tr class="<?php echo $tipo_linha; ?>">
                    <th scope="row"><?php echo $value['id']; ?></th>
                    <td><?php echo $value['nome']; ?></td>      
                    <td><?php echo $value['descricao']; ?></td>      
                    <td><?php echo $value['prazo']; ?></td>      
                    <td><?php echo $value['status']; ?></td>      
                    <td> 
                        <a href="/crud/acao.php?a=deletar&id=<?php echo $value['id']?>" onclick="return confirm('Tem certeza que deseja deletar?');">
                            Deletar
                        </a>
                        -
                         <a href="/crud/index.php?editar=<?php echo $value['id']?>">
                            Editar
                        </a>
                    </td>             
                </tr>  
                <?php
                    }
                ?>
                
                
            </tbody>
            </table>
    </div>
    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>