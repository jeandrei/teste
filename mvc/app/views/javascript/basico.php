<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="col">
            <p class="text-end">Texto direita - text-end</p>
            <p class="text-start">Texto Esquerda - text-start</p>
            <p class="text-center">Texto Centro - center</p>
        </div>
    </div>
    <div class="row"><h3 class="text-center">Javascript</h3>
        Limpar o console = Control + L
    </div>

    
<?php require APPROOT . '/views/inc/footer.php'; ?>


<script>

/**
 * Methodos que podemos criar dentro de um array
 * aqui para chamar exemplo
 * para chamar square.area(10);
 * 
 */
const square = {
    area:function(num){
        return num * num;
    },
    perimeter:function(num){
        return num * 4;
    }
}
//para chamar people.whoAmI();
const people = {
    name: 'Dexter',
    lastname: 'Walter',
    favoriteFood: 'sweet popcorn',
    whoAmI(){
        console.log(`My name is ${this.name} ${this.lastname} and my favorite food is ${this.favoriteFood}!`);
    }
}

/**
 * Try Catch 
 * testar 
 * tryit(1); Try executado com sucesso
 * tryit(2); Erro ao tentar executar o try num não é 1!
 * 
 */
function tryit(num){
    try{
        if(num == 1){
            console.log("Try executado com sucesso");
        } else {
            throw "Erro ao tentar executar o try num não é 1!";
        }        
    } catch(e){
        console.log(e);       
    }
}

/**
 * Arrow functions
 * add(2,5);
 */
const add = (x,y) => {
    return x + y;
}
//rollDice(); vai retornar um numero aleatório entre 1 e 6
const rollDice = () => {
    return Math.floor(Math.random()*6)+1;
}

/**
 * Implicit Returns é a constante com função em apenas uma linha 
 * dessa forma só funciona se for apenas uma linha
 * 
 */
const newadd = (a,b) => a + b;
const isEven = (num) => num % 2 === 0;

/**
 * Filter array
 * neste exemplo usamos o filter array para trazer os números impares
 * como usar: odds
 */
const nums = [9,8,7,6,5,4,3,2,1];
const odds = nums.filter(n => {
    return n % 2 === 1;
});

/**
 * Diferença entre array e objeto
 */
let myArray = [];//array
const myObject = {
    name: 'MYNAME',
    lastName: 'MYLASTNAME',
    age: '18',
    weight: '78'
};

/**
 * null - never assumed by default, you can use it to reset/clear a variable
 * undefined - default value of unitialized variables, não tem nada lá
 * NaN - Not a Number example: 3 * 'hi'
 */

/**
 * typeof - retorna o tipo de uma variável
 */
console.log(typeof 'Hei');//retornará string;

/**
 * Para importar um script a melhor prática é dentro do header usando defer
 * <script src="assets/scripts/app.js" defer>
 * o que o defer faz é carregar o script o mais rápido possível sem
 * parar o carregamento da página
 * */


</script>
