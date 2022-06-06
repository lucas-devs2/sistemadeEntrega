<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encomendas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<?php
    $conn = new PDO("mysql:dbname=entrega;host=localhost", "root", "");
?>
<body>
    <main class="container">
        <div class="row">
            <div class="col">
                <h1>
                    Encomendas
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <td>Rastreador</td>
                            <td>CEP</td>
                            <td>Bairro</td>
                            <td>Entregador</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php                        
                            $sel = $conn->PREPARE("SELECT encomenda.rastreador as rastreador,encomenda.cep as cep, encomenda.bairro as bairro, entregador.nome as entregador FROM encomenda LEFT JOIN entregador on encomenda.entregador_id = entregador_id;");
                            $sel->execute();
                            $result = $sel->fetchAll();
                           // var_dump($result);
                            //die;                            
                            foreach($result as $res){
                                echo "<tr><td>";
                                echo $res["rastreador"];
                                echo "</td><td>";
                                echo $res["cep"];
                                echo "</td><td>";
                                echo $res["bairro"];
                                echo "</td><td>";
                                echo $res["entregador"];
                                echo "</td></tr>";
                                
                            }                                                
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    
    
</body>
</html>