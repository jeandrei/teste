<?php
    // para tr sessão tem que ter session_start();
    session_start();

    // Flash message helper
    // EXAMPLE - flash('register_success', 'You are now registered', 'alert alert-danger');
    /// DISPLAY IN VIEW - echo flash('register_success');
    // register_success é o nome então no view basta chamar pelo nome para exibir a message echo flash('register_success');
    function flash($name = '', $message = '', $class = 'alert alert-success'){
        if(!empty($name)){
            if(!empty($message) && empty($_SESSION[$name])){
                if(!empty($_SESSION[$name])){
                    unset($_SESSION[$name]);
                }

                if(!empty($_SESSION[$name. '_class'])){
                    unset($_SESSION[$name. '_class']);
                }

                $_SESSION[$name] = $message;
                $_SESSION[$name. '_class'] = $class;
            } elseif(empty($message) && !empty($_SESSION[$name])){
                $class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name. '_class'] : '';
                echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';                
                unset($_SESSION[$name]);
                unset($_SESSION[$name. '_class']);
            }
        }
    }

    // VERIFICA SE O USUÁRIO ESTÁ LOGADO
    function isLoggedIn(){
        if(isset($_SESSION[SE.'user_id'])){
            return true;
        } else {
            return false;
        }
    }




?>