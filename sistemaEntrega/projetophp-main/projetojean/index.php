<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrega Justa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<style>
    h1{
        font-size:2em;
        font-shadow:2 3px;
        color: black;
        text-align:center;
        border-bottom: 5px dotted darkgray;
        padding-bottom:1em; 
    }    
    #cad-distribuidor{
        width:800px;
        margin:auto;
    }
</style>
<?php
    $conn = new PDO("mysql:dbname=entrega;host=localhost", "root", "");
?>
<body>
    <main class="container">
        <div class="row">
            <div class="col">
                <h1>
                    Entrega Justa - Sistema de Distribuição de Encomendas
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col">                            
                <form method="POST">
                    <p class="h3 text-center">
                        Cadastro de Entregadores
                    </p>
                    <input type="text" class="form-control" name="nome" placeholder="Nome Entregador">
                    <input type="text" class="form-control" name="cpf" placeholder="CPF Entregador">
                    <select class="form-control" name="bairro">
                    <option value="Boa Vista">Boa Vista</option>
                    <option value="Heliopolis">Heliopolis</option>
                    <option value="Novo Heliopolis">Novo Heliopolis</option>
                    <option value="Magano">Magano</option>
                    <option value="Brasília">Brasília</option>
                    <option value="Centro">Centro</option>
                    <option value="Santo Antônio">Santo Antônio</option>
                    <option value="São José">São José</option>
                    <option value="Cohab 1">Cohab 1</option>
                    <option value="Cohab 2">Cohab 2</option>
                    <option value="Cohab 3">Cohab 3</option>
                    <option value="Liberdade">Liberdade</option>
                    <option value="Indíano">Indiano</option>
                    <option value="Mundau">Mundau</option>
                    <option value="Vila do Quartel">Vila do Quartel</option>
                    </select>
                    <div style="display:flex; justify-content:right;">
                        <button class="btn btn-outline-primary mt-2" type="submit">
                            Criar
                        </button>   
                    </div>                
                </form>                                                            
            </div>
            <div class="col">
                <p class="h3 text-center">                    
                    Listagem dos Entregadores
                </p>                
                <table class="table">
                    <thead class="table-dark fs-6 text-center">
                        <tr>
                            <td>Id</td>
                            <td>Nome</td>
                            <td>Bairro</td>
                            <td>Ações</td>
                        </tr>
                    </thead>
                    <tbody class="fs-6 text-center">                                              
                        <?php
                        $selecao =$conn->PREPARE("SELECT * FROM entregador;");
                        $selecao->execute();
                        $resultado = $selecao->fetchAll();                        
                        foreach($resultado as $campo){
                            echo "<tr><td>";
                            echo $campo["id"];
                            echo "</td><td>";
                            echo $campo['nome'];
                            echo "</td><td>";
                            echo $campo['bairro'];
                            echo "</td></tr>";
                        }                        
                        ?>
                    </tbody>
                </table>      
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h2>
                    Cadastro de Encomendas
                </h2>
                <form method="POST">
                    <input class="form-control" type="text" name="rastreador" placeholder="Rastreador da Encomenda">
                    <input class="form-control"  type="text" name="cep" placeholder="Insira o CEP">
                    <button class="btn btn-primary" type="submit">Inserir</button>
                </form>
            </div>
            <div class="col">
                <h2>                    
                    Páginas de Administração
                </h2>
                <div class="btn-group d-flex justify-content-center mt-1" role="group" aria-label="Basic example">
                    <a href="encomendas.php" class="txt-white">    
                        <button type="button" class="btn btn-primary">
                            Encomendas
                        </button>
                    </a>
                    <button type="button" class="btn btn-primary">Entregas</button>
                    <button type="button" class="btn btn-primary">Atribuição</button>                      
                </div>
            </div>
        </div>    
    </main>    
    <?php        
        if(isset($_POST['nome'])&&isset($_POST['bairro'])&&isset($_POST['cpf'])){
            $nome = $_POST['nome'];    
            $cpf = $_POST['cpf'];
            $bairro = $_POST['bairro'];
            $stmt = $conn->prepare("INSERT INTO entregador (nome,bairro,cpf) VALUES (:N, :B, :C)");
            $stmt->bindParam(':N',$nome);
            $stmt->bindParam(':C',$cpf);
            $stmt->bindParam(':B',$bairro);
            $stmt->execute();           
        }
        if(isset($_POST['rastreador'])&&isset($_POST['cep'])){
            $rastreador = $_POST['rastreador'];    
            $cep = $_POST['cep'];            
            $link = "https://viacep.com.br/ws/$cep/json/";
            $ch = curl_init($link);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $resposta = json_decode(curl_exec($ch),true);         
            curl_close($ch);   
            $bairro = $resposta['bairro'];
            $stmt = $conn->prepare("INSERT INTO encomenda(rastreador,cep,bairro) VALUES (:RASTREADOR, :CEP, :BAIRRO)");
            $stmt->bindParam(':RASTREADOR',$rastreador);
            $stmt->bindParam(':CEP',$cep);
            $stmt->bindParam(':BAIRRO',$bairro);
            $stmt->execute();           
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>

<!--  
create table entregador(
id int(11) primary key auto_increment, 
nome varchar(45) not null, 
bairro varchar(45) not null, 
cpf varchar(14) not null
);

create table encomenda(
id int(11) primary key auto_increment, 
rastreador varchar(45) not null, 
cep varchar(45) not null, 
bairro varchar(14),
entregador_id int(11),
FOREIGN KEY (entregador_id) REFERENCES entregador (id)
);
); -->