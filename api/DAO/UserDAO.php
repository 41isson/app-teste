<?php

namespace DAO;

use mysqli;
use mysqli_sql_exception;

class UserDAO {
    private $conn;

    public function __construct() {
        $this->conn = (new Connection())->getConnection();
    }

    public function GetUserDAO(){
        try{
            $list_users = $this->conn->query("SELECT * FROM tb_usuario");
        
            return $list_users->fetch_all();
        }catch(mysqli_sql_exception $e){
            return ['status' => 'error', 'message' => 'Failed to create user: ' . $e->getMessage()];

        }
    }


    public function PostUserDAO(array $userData) {
        try {
            // Preparar a declaração
            $stmt = $this->conn->prepare("CALL meteorologia.sp_insert_usuario(?, ?, ?, ?)");

            if ($stmt === false) {
                throw new mysqli_sql_exception("Failed to prepare statement: " . $this->conn->error);
            }

    
            // Vincular os parâmetros. O primeiro parâmetro é o tipo dos dados
            $stmt->bind_param("ssss", 
                $userData['nome'], 
                $userData['casa_cep'], 
                $userData['email'], 
                $userData['senha'],
            );

            // Executar a declaração
            $stmt->execute();

            // Verificar se houve erros na execução
            if ($stmt->error) {
                throw new mysqli_sql_exception("Failed to execute statement: " . $stmt->error);
            }

            return ['status' => 'success', 'message' => 'User created successfully'];
        } catch (mysqli_sql_exception $e) {
            // Tratar exceções
            return ['status' => 'error', 'message' => 'Failed to create user: ' . $e->getMessage()];
        } finally {
            // Fechar a declaração
            if ($stmt) {
                $stmt->close();
            }
        }
    }
}
