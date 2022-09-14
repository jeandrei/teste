<?php

//Funções de validação back end

function imprimeuf($ufsec){
    $arrayEstados = array(
        'AC',
        'AL',
        'AM',
        'AP',
        'AC',
        'BA',
        'CE',
        'DF',
        'ES',
        'GO',
        'MA',
        'MT',
        'MS',
        'MG',
        'PA',
        'PB',
        'PR',
        'PE',
        'PE',
        'PI',
        'RJ',
        'RN',
        'RN',
        'RO',
        'RS',
        'RR',
        'SC',
        'SE',
        'SP',
        'TO' 
      );  
      foreach($arrayEstados as $uf){ 
        //iduf tem que ser passada pelo post
        if($uf == $ufsec){
          $html .= '<option selected value="'.$uf.'" '.'>'.$uf.'</option>';
        }
        else{
        $html .='<option value="'.$uf.'" '.'>'.$uf.'</option>';           
    
      }
    
    }
    return $html;
    }


    function validaCPF($cpf) {
 
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
         
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }
        return true;
      }


      function validaCNPJ($cnpj)
      {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

        // Verifica se todos os digitos são iguais
        //para evitar 000000000000 ou 999999999999
        if (preg_match('/(\d)\1{13}/', $cnpj))
        return false;
        
        // Valida tamanho
        if (strlen($cnpj) != 14)
          return false;

        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
          return false;	

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
        {
          $soma += $cnpj[$i] * $j;
          $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
          return false;

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
        {
          $soma += $cnpj[$i] * $j;
          $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
      }


      
      function validacelular($celular){
        if (preg_match('/(\(?\d{2}\)?) ?9?\d{4}-?\d{4}/', $celular)) {
            return true;
        } else {
            return false;
        }
      }

      //valida telefone convencional e celular
      function validatelefone($numero){       
          if (preg_match('/^(?:(?:\+|00)?(55)\s?)?(?:\(?([1-9][0-9])\)?\s?)?(?:((?:9\d|[2-9])\d{3})\-?(\d{4}))$/', $numero)) {
          return true;
        } else {
          return false;
        }
      }



      

            
      //função que verifíca se a a data informada tem uma idade mínima
      //retorna true or false
      //idadeMinima('12-03-2020',5) verifica se a data informada tem no mínimo 5 anos
      //também retorna false se for informado uma data maior que a data atual
      function idadeMinima($data,$minima){
      $formatado = date('Y-m-d',strtotime($data));
      $ano = date('Y', strtotime($formatado));
      $mes = date('m', strtotime($formatado));
      $dia = date('d', strtotime($formatado));
      $anominimo = date('Y', strtotime('-'.$minima.'years'));      
      
      if ( !checkdate( $mes , $dia , $ano )                   // se a data for inválida
           || $ano < $anominimo                                // ou o ano menor que a data mínima
           || mktime( 0, 0, 0, $mes, $dia, $ano ) > time() )  // ou a data passar de hoje
        {
          return false;
        }else{
          return true;
        }
      }
      

      
      //Função para entrada de dados
      function html($data)
      {
          //tira espaço em branco
          $data = trim($data);
          //remove barras
          $data = stripslashes($data);
          //transforma tags html exemplo <b> -> $b&gt dessa forma impede html injection
          $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
          return $data;
      } 

      //função para saida de dados
      function htmlout($text)
      {
          echo html($text);
      }

      //função para imprimir data no formato brasileiro
      function datebr($date){
        $result = date('d/m/Y', strtotime($data));    
        return $result;
      }

      //função para verificar conteúdo de dados
      function debug($data){
        echo("<pre>");
        print_r($data);
        echo("</pre>");
        die();
      }
      

      function valida($data){  
        
        if(empty($data)){
          return false;
        }
        
        // se a data for maior que a data atual retorna falso
        if($data > date("Y-m-d")){
          return false;
        }
      
        $tempDate = explode('-', $data);
        if(checkdate($tempDate[1], $tempDate[2], $tempDate[0])){
          return true;
        } else {
          return false;
        }  
      }      
      
      //função para formatar a data no padrão brasileiro
      function formatadata($data){  
        $result = date('d/m/Y', strtotime($data));    
        return $result;
      }    

      
      function validaemail($email){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
          return true;
        } else {
          return false;
        }
        
      
      }
      
      
      function RandomPassword($length = 6){
        $chars = "0123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";
        return substr(str_shuffle($chars),0,$length);
      }  


      //função para dar o checked em check fields exemplo em editar de pessoas
      function checked($value, $array){
        if(!empty($array)){
          if(in_array($value, $array)){
            echo 'checked';
          }
        }        
      }

      //Validação dos dados antes de enviar o formulário
      // validate($data['pessoaNome'],['required',['isnumeric','min'=>10,'max'=>20]]);
      function validate($data,$options){       

        //verifico se foi passado o option require
        $required = (in_array('required',$options));
        
        //se for campo obrigatório e passar o campo em branco já retorno campo obrigatório          
        if($required && (empty($data) || $data == 'null')){
          return 'Campo Obrigatório!';
        }
     
        //caso for passado alguma coisa faço a validação
        foreach($options as $option){ 
          
          //aqui verifico se é um array primeiro pq se for eu tenho que pegar o item zero do array
          //para poder pegar os valores
          if(is_array($option))        {
            $switch = $option[0];
          } else {
            $switch = $option;
          }

          switch ($switch){
            case 'isstring':
              if($required || !empty($data)){
                if(!is_string($data)){
                  return 'Deve ser um texto!';
                } 
                if(!empty($option['min']) && (strlen($data) < $option['min'])){
                    return 'Mínimo ' . $option['min'] . ' caracteres!';
                }
                if(!empty($option['max']) && (strlen($data) > $option['max'])){
                  return 'Máximo de ' . $option['max'] . ' caracteres!';
                }                 
              }              
              break;
            /* $data['erro'] = validate(['isnumeric','min'=>10,'max'=>20]]) número mínimo permitido e número máximo */
            case 'isnumeric':                
              if($required || !empty($data)){
                if(!is_numeric($data)){
                  return 'Deve ser um número!';
                } 
                if(!empty($option['min']) && $data < $option['min']){
                    return 'Valor não pode ser menor que ' . $option['min'] . '!';
                }
                if(!empty($option['max']) && $data > $option['max']){
                  return 'Valor não pode ser maior que ' . $option['max'] . '!';
                }                 
              }              
              break;
            /*$data['erro'] = ['date','min'=>18,'futuredate'=>false]] idade mínima e se aceita data futura */
            case 'date':              
              if($required || ($data!='null')){               
                if(!empty($option['min']) && idadeMinima($data,$option['min'])){
                  return 'Idade mínima é de '.$option['min'].' anos!';
                }
                if(($option['futuredate']==false) && $data > date("Y-m-d")){
                  return 'Não é permitido informar data futura!';
                }
              }
              break;
            case 'email':
              if($required || !empty($data)){
                if(!validaemail($data)){
                  return 'Email invalido!';
                }
              }              
              break;
            case 'phone':
              if($required || !empty($data)){
                if(!validatelefone($data)){
                  return 'Telefone invalido!';
                }
              }              
              break;
            case 'cphone':
              if($required || !empty($data)){
                if(!validacelular($data)){
                  return 'Celular invalido!';
                }
              }              
              break;
            case 'cpf':
              if($required || !empty($data)){
                if(!validaCPF($data)){
                  return 'CPF invalido!';
                }
              }              
              break;
            case 'cnpj':
              if($required || !empty($data)){
                if(!validaCNPJ($data)){
                  return 'CNPJ invalido!';
                }
              }              
              break;
          }
        }   
       

      }

?>