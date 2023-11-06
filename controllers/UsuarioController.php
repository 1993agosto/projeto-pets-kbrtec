<?php 
    require_once('../model/Usuario.php');

    if(isset($_POST['btn-cadastrarUsuario'])) {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $confirmarSenha = $_POST['confirmarSenha'];

        if($senha !== $confirmarSenha) {
            echo "<script>alert('Erro! Digite as duas senhas iguais!')</script>";
            echo "<script> window.location.href='http://localhost/projeto-mrEsgoto/painel/cadastrar.php'</script>";
        } else {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $adicionarUsuario = Usuario::adicionarUsuario($nome, $email, $senhaHash);

            if($adicionarUsuario){
                echo "<script>alert('Usuário cadastrado com sucesso!')</script>";
                echo "<script> window.location.href='http://localhost/projeto-mrEsgoto/painel/painel.php'</script>";
            } else {
                echo "<script>alert('Erro ao cadastrar!')</script>";
                echo "<script> window.location.href='http://localhost/projeto-mrEsgoto/painel/cadastrar.php'</script>";
            }
        }
    }

    if(isset($_POST['btn-autenticar'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        session_start();

        $autenticarUsuario = Usuario::autenticarUsuario($email, $senha);

        if($autenticarUsuario) {
            $pdo = DbConnect::realizarConexao();
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE emailUsuario = ?");
            $stmt->execute(array($email));
            $dados = $stmt->fetch(PDO::FETCH_OBJ);

            $_SESSION['id'] = $dados->idUsuario;
            $_SESSION['logado'] = true;

            echo "<script>alert('Usuário autenticado com sucesso!')</script>";
            echo "<script> window.location.href='http://localhost/projeto-mrEsgoto/painel/painel.php'</script>";
        } else {
            echo "<script>alert('Erro ao autenticar!')</script>";
            echo "<script> window.location.href='http://localhost/projeto-mrEsgoto/painel/login.php'</script>";
        }
    }

    if(isset($_POST['btn-deletar'])) {
        $id = $_POST['id'];
        $deletarUsuario = Usuario::deletarUsuario($id);
        if($deletarUsuario){
            echo "<script>alert('Usuário deletado com sucesso!')</script>";
            echo "<script> window.location.href='http://localhost/projeto-mrEsgoto/painel/painel.php'</script>";
        } else {
            echo "<script>alert('Erro ao deletar!')</script>";
            echo "<script> window.location.href='http://localhost/projeto-mrEsgoto/painel/painel.php'</script>";
        }
    }

    if(isset($_POST['btn-editar'])) {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $atualizarUsuario = Usuario::atualizarUsuario($id, $nome, $email, $senhaHash);

        if($atualizarUsuario) {
            echo "<script>alert('Usuário atualizado com sucesso!')</script>";
            echo "<script> window.location.href='http://localhost/projeto-mrEsgoto/painel/painel.php'</script>";
        } else {
            echo "<script>alert('Erro ao atualizar!')</script>";
            echo "<script> window.location.href='http://localhost/projeto-mrEsgoto/painel/painel.php'</script>";
        }
    }


?>