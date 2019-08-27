<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// GET: Todos los usuarios.
$app->get('/api/user', function(Request $request, Response $response){
    try{
        $db = new db();
        $db = $db->conectDB();

        $resultado = $db->query("SELECT * FROM user");
        $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC|PDO::PARAM_STR);
        return jsonResponse($response, $resultado);
    }catch(PDOException $e){
        echo '{"error" : {"text": '. $e->getMessage(). '}}';
    }
});

// GET: Todos los usuarios.
$app->get('/api/test', function(Request $request, Response $response){
    try{
        $array = array(
            'id'=>17,
            'firstname'=>'Alfonso Miguel',
            'lastname'=>'Evangelista',
            'birthdate'=>DateTime::createFromFormat('c','1992-05-17'),
            // 'birthdate'=> date_format(new Datetime('1992-05-17'), 'c'),
            'status'=>true
        );
       
        return jsonResponse($response, $array);
    }catch(PDOException $e){
        echo '{"error" : {"text": '. $e->getMessage(). '}}';
    }
});



// GET Unico usuario.
$app->get('/api/user/{id}', function(Request $request, Response $response){
    try{
        $db  = new db();
        $db = $db->conectDB();

        $userId = $request->getAttribute('id');
        $resultado = $db->query("SELECT * FROM user WHERE id = $userId");
        $resultado = $resultado->fetchAll(PDO::FETCH_OBJ);
        return jsonResponse($response, $resultado);
    }catch(PDOException $e){
        echo '{"error" : {"text": '. $e->getMessage(). '}}';
    }
});

// POST: cear nuevo usuario
$app->post('/api/user/new', function(Request $request, Response $response){
    try{

        $db = new db();
        $columns = ['firstname','lastname','username','password'];
        $db->addEntity(columns, $request);
        return jsonResponse($response, array('message' => 'New user created'));
    }catch(PDOException $e){
        echo '{"error" : {"text": '. $e->getMessage(). '}}';
    }
});

// PUT: modificar usuario.
$app->put('/api/user/update/{id}', function(Request $request, Response $response){
    try{
        $db = new db();
        $array = array('firstname');
        $db->updateEntity('user', $array, $request);
        return jsonResponse($response, array('message'=>'Usuario actualizado'));
    }catch(PDOException $e){
        echo '{"error" : {"text": '. $e->getMessage(). '}}';
    }
});

// PATCH: modificación partial.
$app->patch('/api/user/update/{id}', function(Request $request, Response $response){
    try{
        $db = new db();
        $array = array('firstname');
        $db->updateEntity('user', $array, $request);
        return jsonResponse($response, array('message'=>'Usuario actualizado'));
    }catch(PDOException $e){
        echo '{"error" : {"text": '. $e->getMessage(). '}}';
    }
});

// DELETE: eliminar usuario.
$app->delete('/api/user/delete/{id}', function(Request $request, Response $response){
    try{
        $userId = $request->getAttribute('id');
        $sql = "DELETE FROM user WHERE id = :id";

        $db = new db();
        $db = $db->conectDB();

        $resultado = $db->prepare($sql);
        $resultado->bindParam(':id', $userId);
        $resultado->execute();

        if($resultado->rowCount() >0){
            return jsonResponse($response, array('message'=>'Usuario eliminado'));
        }else  return jsonResponse($response, array('message'=>'El usuario no existe'));
    }catch(PDOException $e){
        echo '{"error" : {"text": '. $e->getMessage(). '}}';
    }
});
?>