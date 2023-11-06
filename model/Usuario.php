<?php 

require_once('../db/connect.php');
class Usuario extends DbConnect {
    public static function adicionarUsuario($nome, $email, $senha) {
        $pdo = DbConnect::realizarConexao();
        try {
            $role = 'ADMIN';
            $stmt = $pdo->prepare("INSERT INTO usuarios VALUES (null, ?, ?, ?, ?)");
            $stmt->execute(array($nome, $email, $senha, $role));
            return true;

        } catch (PDOException $e){
            echo ("Ocorreu um erro com o banco de dados: " .$e);
            return false;
        }
    }

    public static function autenticarUsuario($email, $senha) {
        $pdo = DbConnect::realizarConexao();
        try {
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE emailUsuario = ?");
            $stmt->execute(array($email));

            if($stmt->rowCount() == 1) {
                $dados = $stmt->fetch(PDO::FETCH_OBJ);
                $senhaHash = $dados->senhaUsuario;
                if(password_verify($senha, $senhaHash)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }

        } catch (PDOException $e) {
            echo ("Ocorreu um erro com o banco de dados: " .$e);
            return false;
        }
    }

    public static function deletarUsuario($id) {
        $pdo = DbConnect::realizarConexao();
        try {
            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE idUsuario = ?");
            $stmt->execute(array($id));
            return true;
        } catch(PDOException $e){
            return false;
        }
    }

    public static function atualizarUsuario($id, $nome, $email, $senha) {
        $pdo = DbConnect::realizarConexao();
        try {
            $stmt = $pdo->prepare("UPDATE usuarios SET nomeUsuario = ?, emailUsuario = ?, 
            senhaUsuario = ? WHERE idUsuario = ?");
            $stmt->execute(array($nome, $email, $senha, $id));
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }
}

?>