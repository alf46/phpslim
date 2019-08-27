<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// GET: Todos los clientes.
$app->get('/api/customers', function(Request $request, Response $response){
    try{
        $db  = new db();
        $db = $db->conectDB();

        $resultado = $db->query('SELECT cu.*, dt.* FROM customer as cu join doc_type as dt on cu.document_type = dt.id');
        if($resultado ->rowCount()>0)
        {
            $resultado = $resultado->fetchAll(PDO::FETCH_OBJ);
        }else $resultado = array('message'=>'No existen clientes en la base de datos');

        return jsonResponse($response, $resultado);
      
    }catch(PDOException $e){
        echo '{"error" : {"text": '. $e->getMessage(). '}}';
    }
});

// GET: Unico cliente.
$app->get('/api/customers/{id}', function(Request $request, Response $response){
    try{
        $db  = new db();
        $db = $db->conectDB();

        $userId = $request->getAttribute('id');
        $resultado = $db->query("SELECT * FROM customer WHERE id = $userId");
        if($resultado ->rowCount() > 0)
        {
            $resultado = $resultado->fetchAll(PDO::FETCH_OBJ)[0];
        }else $resultado = array('message'=>'No existen clientes en la base de datos');

        return jsonResponse($response, $resultado);
    }catch(PDOException $e){
        echo '{"error" : {"text": '. $e->getMessage(). '}}';
    }
});

?>