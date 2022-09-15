<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class User {
    private $db;

    public function __construct(){
        //inicia a classe Database
        $this->db = new Database;
    }

    // Register User
    public function register($data){
        $this->db->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        // Bind values
        $this->db->bind(':name',$data['name']);
        $this->db->bind(':email',$data['email']);
        $this->db->bind(':password',$data['password']);

        // Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // Register User
    public function updatepassword($data){       
        $this->db->query('UPDATE users SET password =:password WHERE email=:email');
        // Bind values           
        $this->db->bind(':email',$data['email']);
        $this->db->bind(':password',$data['password']);

        // Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // 2 Login User                
    public function login($email, $password){
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        $hashed_password = $row->password;
        // password_verify — Verifica se um password corresponde com um hash criptografado
        // Logo para verificar não precisa descriptografar 
        // aqui $password vem do formulário ou seja digitado pelo usuário  
        // e $hashed_password vem da consulta do banco e está criptografado
        if(password_verify($password, $hashed_password)){
            return $row;
        } else {
            return false;
        }
    }

    // Find user by email
    public function findUserByEmail($email){
        $this->db->query('SELECT * FROM users WHERE email = :email');
        // Bind value
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        // Check row
        if($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function getEmailById($id){
        $this->db->query('SELECT email FROM users WHERE id = :id');
        // Bind value
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        // Check row
        if($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        } 
    }

      // Find user by id
      public function getUserById($id){
        $this->db->query('SELECT id,name,email,created_at FROM users WHERE id = :id');
        // Bind value
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;            
    }

    public function sendemail($email, $senha){  
        /**
         * 
         * IMPORTANTISSIMO
         * PRIMEIRO ATIVE O ENVIO IMAP
         * 1 - ENTRE NO GMAIL DA CONTA
         * 2 - CLIQUE NA ENGRENAGEM NO CANTO SUPERIOR DIREITO
         * 3 - CLIQUE EM VER TODAS AS CONFIGURAÇÕES
         * 4 - CLIQUEEM ENCAMINHAMENTO POP/IMAP
         * 5 - CLIQUE EM ATIVAR IMAP
         * 6 - CLIQUE EM SALVAR ALTERAÇÕES
         * AGORA ATIVE A OPÇÃO DE ACESSO A APP MENOS SEGURO
         * AINDA NA SUA CONTA GOOGLE ACESSE:
         * https://myaccount.google.com/
         * OU PROCURE POR CONTA GOOGLE
         * 
         * 1 - CLIQUE EM SEGURANÇA
         * 2 - PROCURE POR ACESSO A APP MENOS SEGURO
         * 3 - VAI PEDIR PARA CONFIRMAR SUA SENHA DE ACESSO
         * 4 - ATIVE A OÇÃO PERMITIR APLICATIVOS MENOS SEGUROS
         */              

        /* Exception class. */
        require APPROOT . '/inc/PHPMailer-master/src/Exception.php';

        /* The main PHPMailer class. */
        require APPROOT . '/inc/PHPMailer-master/src/PHPMailer.php';

        /* SMTP class, needed if you want to use SMTP. */
        require APPROOT . '/inc/PHPMailer-master/src/SMTP.php';
    
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;            // Enable verbose debug output
            $mail->isSMTP(true);                                // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';               // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                           // Set SMTP authenticacion to true
            $mail->SMTPSecure = 'ssl';                          // Enable SMTP authentication
            $mail->Username   = APPEMAIL;                       // SMTP username
            $mail->Password   = EMAILPASSWORD;                  // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                            // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            
            //Recipients
            $mail->CharSet = 'UTF-8';
            $mail->setLanguage('pt_br', APPROOT . '/inc/PHPMailer-master/language');
            $mail->setFrom(APPEMAIL, SITENAME);
            $mail->addAddress($email, SITENAME);     // Add a recipient           

            $texto = 'Sua nova senha é :' . $senha;
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Você solicitou uma nova senha de acesso ao ' . SITENAME;
            $mail->Body    = $texto;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }

    }


//class
}
?>