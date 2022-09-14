
/********************************************VALIDAÇÕES****************************** */
/**
 * CNPJ
 * Função para validar o cpf pelo jqueryvalidator é só colocar na classe
 * do input class="cnpj"
 */
 jQuery.validator.addMethod("cnpj", function (cnpj, element) {
    cnpj = jQuery.trim(cnpj); // retira espaços em branco
    // DEIXA APENAS OS NÚMEROS
    cnpj = cnpj.replace('/', '');
    cnpj = cnpj.replace('.', '');
    cnpj = cnpj.replace('.', '');
    cnpj = cnpj.replace('-', '');

    var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
    digitos_iguais = 1;

    if (cnpj.length < 14 && cnpj.length < 15) {
        return this.optional(element) || false;
    }
    for (i = 0; i < cnpj.length - 1; i++) {
        if (cnpj.charAt(i) != cnpj.charAt(i + 1)) {
            digitos_iguais = 0;
            break;
        }
    }

    if (!digitos_iguais) {
        tamanho = cnpj.length - 2;
        numeros = cnpj.substring(0, tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;

        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) {
                pos = 9;
            }
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0)) {
            return this.optional(element) || false;
        }
        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) {
                pos = 9;
            }
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1)) {
            return this.optional(element) || false;
        }
        return this.optional(element) || true;
    } else {
        return this.optional(element) || false;
    }
}, "Informe um CNPJ válido."); /* Mensagem padrão */


/**CPF
 * Função para validar o cpf pelo jqueryvalidator é só colocar na classe
 * do input class="cpf"
 */
jQuery.validator.addMethod("cpf", function(value, element) {
  value = jQuery.trim(value);

   value = value.replace('.','');
   value = value.replace('.','');
   cpf = value.replace('-','');
   while(cpf.length < 11) cpf = "0"+ cpf;
   var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
   var a = [];
   var b = new Number;
   var c = 11;
   for (i=0; i<11; i++){
       a[i] = cpf.charAt(i);
       if (i < 9) b += (a[i] * --c);
   }
   if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
   b = 0;
   c = 11;
   for (y=0; y<10; y++) b += (a[y] * c--);
   if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }

   var retorno = true;
   if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;

   return this.optional(element) || retorno;

}, "Informe um CPF válido");


/**CRM
 * valida CRM só colocar como classe crm
 */
jQuery.validator.addMethod("crm", function (crm, element) {
    countNum = crm.replace(/[^0-9]/g,"").length;
    crmIsValido = countNum >= (crm.length - countNum);
    return this.optional(element) || crmIsValido;
}, "Informe um CRM válido."); /* Mensagem padrão */


/**DATA
 * valida data só colocar como classe databr
 */
jQuery.validator.addMethod("datebr", function (value, element) {
    //contando chars
    if (value.length != 10) return false;
    // verificando data
    var data = value;
    var dia = data.substr(0, 2);
    var barra1 = data.substr(2, 1);
    var mes = data.substr(3, 2);
    var barra2 = data.substr(5, 1);
    var ano = data.substr(6, 4);
    if (data.length != 10 || barra1 != "/" || barra2 != "/" || isNaN(dia) || isNaN(mes) || isNaN(ano) || dia > 31 || mes > 12) return false;
    if ((mes == 4 || mes == 6 || mes == 9 || mes == 11) && dia == 31) return false;
    if (mes == 2 && (dia > 29 || (dia == 29 && ano % 4 != 0))) return false;
    if (ano < 1900) return false;
    return true;
}, "Informe uma data válida");  // Mensagem padrão


/**NÚMEROS
 * 
 * FUNÇÃO PARA PERMITIR APENAS NÚMEROS
 * PARA USAR BASTA COLOCAR O CAMPO COMO CLASSE onlynumbers
 * E PARA EXIBIR A MENSAGEM COLOCAR UM <span id="errmsg"></span>
 * USE TAMBÉM O TIPO NUMBER NO INPUT type="number"
 * 
 * 
 */
 $(document).ready(function () {
	//called when key is pressed in textbox
	$(".onlynumbers").keypress(function (e) {
	   //if the letter is not digit then display error and don't type anything
	   if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		  //display error message
		  alert("Ops! Apenas números são permitidos.");
				 return false;
	  }
	 });
});


/**EMAIL
 * para usar a função de validação de email basta colocar na classe email
 */
jQuery.validator.addMethod("email", 
    function(value, element) {
		//se quiser tornar opcional a validação coloque esse if sempre antes da validação
		if (this.optional(element)) {
			return true;
		}

        return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
    }, 
    "Email inválido"
);


/**CELULAR
 * para usar a função de validação de celular basta colocar na classe celular
 */
jQuery.validator.addMethod('celular', function (value, element) {
    value = value.replace("(","");
    value = value.replace(")", "");
    value = value.replace("-", "");
    value = value.replace(" ", "").trim();
    if (value == '0000000000') {
        return (this.optional(element) || false);
    } else if (value == '00000000000') {
        return (this.optional(element) || false);
    }
    if (["00", "01", "02", "03", , "04", , "05", , "06", , "07", , "08", "09", "10"]
    .indexOf(value.substring(0, 2)) != -1) {
        return (this.optional(element) || false);
    }
    if (value.length < 10 || value.length > 11) {
        return (this.optional(element) || false);
    }
    if (["6", "7", "8", "9"].indexOf(value.substring(2, 3)) == -1) {
        return (this.optional(element) || false);
    }
    return (this.optional(element) || true);
}, 'Celular inválido!');


/**TELEFONE
 * para usar a função de validação de telefone basta colocar na classe telefone
 */
jQuery.validator.addMethod("telefone", 
    function(value, element) {
		//se quiser tornar opcional a validação coloque esse if sempre antes da validação
		if (this.optional(element)) {
			return true;
		}

        return /(^[0-9]{2})?(\s|-)?(9?[0-9]{4})-?([0-9]{4}$)/.test(value);
    }, 
    "Telefone inválido"
);


/**RG não testei ainda
 * para usar a função de validação de telefone basta colocar na classe telefone
 */
 jQuery.validator.addMethod("rg", 
 function(value, element) {
     //se quiser tornar opcional a validação coloque esse if sempre antes da validação
     if (this.optional(element)) {
         return true;
     }

     return /(^\d{1,2}).?(\d{3}).?(\d{3})-?(\d{1}|X|x$)/.test(value);
 }, 
 "RG inválido"
);


/**CEP não testei ainda
 * para usar a função de validação de telefone basta colocar na classe telefone
 */
 jQuery.validator.addMethod("rg", 
 function(value, element) {
     //se quiser tornar opcional a validação coloque esse if sempre antes da validação
     if (this.optional(element)) {
         return true;
     }

     return /(^[0-9]{5})-?([0-9]{3}$)/.test(value);
 }, 
 "CEP inválido"
);

/**SELECT
 * Validação de select field
 * O primeiro options do select o default tem que estar como null
 * <option value="null">Selecione o Bairro</option>
 * a validação é adicionada no rules e messages do jqueryvalidation 
 */
$.validator.addMethod("selectone", function(value, element, arg){
    return arg !== value;
}, "Value must not equal arg.");
  
  




/********************************************MASCARAS****************************** */
/**
 * 
 * mascaras para os formulários todas se aplicam a classe
 * no caso de aplicar mascara a telefone é só 
 * fazer <input type="tel" class="telefone"
 * vai aplicar somente depois de carregar o documento
 * por isso esta dentro da (document).ready()
 * tem que colocar o footer que está neste projeto para lincar com maskedinput.min.js
 * 
 */
 $(document).ready(function() {
	$('.cpf').mask('000.000.000-00', {reverse: true});
	$('.cnpj').mask('00.000.000/0000-00', {reverse: true});
	$(".celular").mask("(00) 00000-0009");
	$(".telefone").mask("(00) 0000-0009");
});


/**
 * *********************************MANIPULAÇÃO DE DADOS*****************************
 */
/**
 * 
 * FUNÇÃO PARA COLOCAR TUDO EM MAIÚSCULO
 * onkeydown="upperCaseF(this)" 
 */
 function upperCaseF(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
  }
  
  /**
   * 
   * FUNÇÃO PARA COLOCAR TUDO EM minusculo
   * onkeydown="lowerCaseF(this)" 
   */
   function lowerCaseF(a){
      setTimeout(function(){
          a.value = a.value.toLowerCase();
      }, 1);
    }





/**
 * 
 * FUNÇÃO PARA ADICIONAR CLASSE
 * função para adicionar nova classe a objetos
 * exemplo para adicionar a classe cpf que tem a mascara do cpf
 * no final do formulário basta colocar
 * <script>  addclass('cpf','cpf'); </script>
 * onde id é o id do campo e new class é a nova classe a ser adicionada neste
 * caso cpfmask que coloca mascara no cpf
 * 
 */
function addclass(id,newclass){
  var element = document.getElementById(id);
  var addclass = newclass;
  element.classList.add(addclass);
}



/**
 * 
 * Função para dar o foco em um campo
 * 
 */
 function focofield(field)
 {
	 document.getElementById(field).focus();
 }

/**
 * 
 * Funçõ que retorna true se confirmar e false se não confirmar uma pergunta
 * 
 */
 function question(ask)
{
	return confirm (ask);
}	










/**
 * 
 * 
 * DAQUI PARA BAIXO TEM QUE TESTAR
 * 
 * 
 * 
 */


function CheckForm(id){
	var checked=false;
	var elements = document.getElementsByName(id);
	for(var i=0; i < elements.length; i++){
		if(elements[i].checked) {
			checked = true;
		}
	}
	if (!checked) {
		checked = false;
	}
	return checked;
}

function checkedRadioBtn(sGroupName)
    {   
        var group = document.getElementsByName(sGroupName);

        for ( var i = 0; i < group.length; i++) {
            if (group.item(i).checked) {
                return group.item(i).id;
            } else if (group[0].type !== 'radio') {
                //if you find any in the group not a radio button return null
                return null;
            }
        }
		}
		
	


//função para o botão avançar do formulário
$(document).ready(function () {
	//Initialize tooltips
	$('.nav-tabs > li a[title]').tooltip();
	
	//Wizard
	$('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

		var $target = $(e.target);
	
		if ($target.parent().hasClass('disabled')) {
			return false;
		}
	});

	$(".next-step").click(function (e) {

		var $active = $('.nav-tabs li>a.active');
		$active.parent().next().removeClass('disabled');
		nextTab($active);

	});
	$(".prev-step").click(function (e) {

		var $active = $('.nav-tabs li>a.active');
		prevTab($active);

	});
});

function nextTab(elem) {
	$(elem).parent().next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
	$(elem).parent().prev().find('a[data-toggle="tab"]').click();
}


//mostrar o nome do arquivo no file custom - no selecionar arquivo
$('.custom-file input').change(function (e) {
	$(this).next('.custom-file-label').html(e.target.files[0].name);
});



//fileValidation(campo tipo field,id do span para apresentar o erro);"
// onchange="return fileValidation('comprovante_residencia','res_erro');"
function fileValidation(myfiel,span)
{
	var fileInput = document.getElementById(myfiel);
	var filePath = fileInput.value;
	var errorspan = span;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if(!allowedExtensions.exec(filePath)){				
		document.getElementById(errorspan).textContent="Apenas arquivo do tipo JPEG, PNG ou GIFT são permitidos!";
		fileInput.value = '';			
        return false;
    }else{
		document.getElementById(errorspan).textContent="";
        return true;
    }
}


/* mensagens para a validação do jquery validate */
let custommsg = {
    "required": 'Campo obrigatório!',
    "minlength": 'Mínimo ',
    "selectone": 'Campo obrigatório!',
    "email": 'Email valido!'
};