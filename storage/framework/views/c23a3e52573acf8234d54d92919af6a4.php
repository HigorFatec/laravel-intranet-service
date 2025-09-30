<?php 
use Illuminate\Support\Str; ?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">



<style>
      .red{
      background-color: #184693 !important;
    }  
    
    body {
        background-color: #ffffff;
        font-family: 'Montserrat', sans-serif;
        color: #184693;
    }

    .login-container {
        margin-top: 80px;
    }

    .card {
        border-radius: 20px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        color: #184693;
        padding: 30px;
    }

    /* Apenas para login */
    .card-login {
        background-color: #184693;
        color: white;
    }

    .card-title-login {
    color: #ffffff !important;
}


    .card-title {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: center;
        color: #ffffff;
    }

    input[type="text"],
    input[type="password"] {
        border-radius: 10px;
        border: none;
        padding: 15px;
        font-size: 1.1rem;
        width: 100%;
        margin-bottom: 20px;
    }

    input:focus {
        outline: none;
        box-shadow: 0 0 0 2px #ffffff;
    }

    label {
        color: #ffffff;
        font-weight: 500;
        margin-bottom: 8px;
        display: block;
    }

    .btn-cadastrar {
        background-color: #ffffff;
        color: #184693;
        font-size: 1.2rem;
        border-radius: 12px;
        padding: 12px 30px;
        font-weight: bold;
        width: 100%;
        transition: background 0.3s ease, color 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-cadastrar:hover {
        background-color: #dbe6ff;
        color: #184693;
    }

    .alerta {
        margin-bottom: 20px;
    }

    .erro {
        background-color: #d32f2f;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

/* TABELA */  

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 20px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        background-color: white;
    }

    thead {
        background-color: #184693;
        color: white;
        font-weight: bold;
        text-transform: uppercase;
    }

    td {
        padding: 12px;
        text-align: center;
        font-size: 1rem;
        color: #333; /* Texto mais escuro para melhor leitura */
    }

    th {
        padding: 15px;
        text-align: center;
        font-size: 0.95rem;
        color: #b6b6b6; /* Texto mais escuro para melhor leitura */
    }

    tbody tr:nth-child(even) {
        background-color: #f2f6ff;
    }

    tbody tr:hover {
        background-color: #e6eeff;
    }

    .btn.btn-primary.blue {
        background-color: #184693;
        color: white;
        border-radius: 8px;
        padding: 6px 12px;
        transition: 0.3s ease;
    }

    .btn.btn-primary.blue:hover {
        background-color: #123675;
    }

    .card-title {
        font-size: 1.8rem;
        color: #184693;
    }

    .input-field input[type="text"] {
        border-bottom: 2px solid #184693;
        color: #184693;
    }

    .input-field input[type="text"]:focus {
        border-bottom: 2px solid #123675;
        box-shadow: 0 1px 0 0 #123675;
    }

/* STYLE PARA BOTAO STATUS */

.progress .determinate {
  transition: width 1s ease-in-out;
}


/* teclado */
.keyboard-container {
    display: none;
    position: fixed;
    bottom: 0;
    left: 0; right: 0;
    background: #184693;
    padding: 10px;
    z-index: 9999;
    text-align: center;
}
.keyboard-container button {
    margin: 5px;
    padding: 10px 14px;
    font-size: 18px;
    border: none;
    border-radius: 8px;
    background-color: #fff;
    color: #184693;
    cursor: pointer;
}
.keyboard-container .row {
    margin-bottom: 5px;
}
.keyboard-close {
    background-color: red;
    color: black !important;
    font-weight: 700;
    font-size: 16px;
    line-height: 1.3;
    padding: 10px 16px;
    min-width: 80px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    user-select: none;
}

    
    </style>


</head>
<body>

    <!-- Dropdown Structure -->
    <ul id='dropdown1' class='dropdown-content'>

    </ul>
  

  <!-- Dropdown Structure -->
  <ul id="dropdown2" class="dropdown-content">
    

<li>
  <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    Sair
  </a>
</li>

<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
  <?php echo csrf_field(); ?>
</form>




</ul>

    
  <nav class="red">
    <div class="nav-wrapper container">
      <a href="#" class="brand-logo center">Ordem de Serviço</a>
      <a href="#" class="brand-logo" href="index.html">
        <img src="<?php echo e(asset('img/LogoSite.png')); ?>" style="width: 100px; height: auto; margin:10px;margin-left:80px">
    </a>
      <ul id="nav-mobile" class="left">
        <a href="#" data-target="slide-out" class="sidenav-trigger left  show-on-large"><i class="material-icons">menu</i></a>
      </ul>

      <ul id="nav-mobile" class="brand-logo center">
        <li class="hide-on-med-and-down">
          <i class="material-icons left" style="margin-left:400px">visibility</i><?php echo e(\Illuminate\Support\Facades\DB::table('sessions')->where('user_id','!=',null)->count()); ?>

        </li>
      </ul>

      <?php if(auth()->guard()->check()): ?>
      <ul id="nav-mobile" class="right">
        <li>
          <a href="" class="dropdown-trigger" data-target='dropdown2'>
            Olá <?php echo e(Str::limit(auth()->user()->NOMFUN, 10)); ?> <i class="material-icons right">expand_more</i>
          </a>
        </li>
      </ul>
    <?php else: ?>
      <ul id="nav-mobile" class="right">
        <li><a href="<?php echo e(route('login')); ?>">Login <i class="material-icons right">lock</i></a></li>
      </ul>
    <?php endif; ?>


      <?php if(@auth()->user()->CODFUN != null): ?>
        
      <ul id="slide-out" class="sidenav">
        <li>
            <div class="user-view">
                <div class="background red">
                    <img src="<?php echo e(asset('img/office2.jpg')); ?>" style="opacity: 0.5"> 
                </div>
                <a href="#user"><img class="circle" src="https://upload.wikimedia.org/wikipedia/commons/a/a6/Anonymous_emblem.svg"></a>

                <a href="#name"><span class="white-text name"> <?php echo e(auth()->user()->NOMFUN); ?> </span></a>

            </div>
        </li> 

        <li><a href="<?php echo e(route('dashboard')); ?>"><i class="material-icons">home</i>Home</a></li>
        <?php if($isAdmin): ?>
        <a class="red-text center"><b>Painel Administrador</b></a>
        <li><a href="<?php echo e(route('admin.create.form')); ?>"><i class="material-icons">person_add</i>Criar Administrador</a></li>
        <?php endif; ?>
        
    </ul>
    <?php endif; ?>



    </div>
  </nav>

<?php echo $__env->yieldContent('conteudo'); ?>
    <!-- Compiled and minified JavaScript -->

<script>
let activeInput = null;

document.addEventListener('DOMContentLoaded', function () {
    // Seleciona todos os inputs da página
    const inputs = document.querySelectorAll('input');

    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            activeInput = input;
            showKeyboard();
        });
    });
});

function insertChar(char) {
    if (activeInput) {
        const start = activeInput.selectionStart;
        const end = activeInput.selectionEnd;
        const value = activeInput.value;
        activeInput.value = value.substring(0, start) + char + value.substring(end);
        activeInput.selectionStart = activeInput.selectionEnd = start + 1;
        activeInput.focus();
    }
}

function backspace() {
    if (activeInput) {
        const start = activeInput.selectionStart;
        const end = activeInput.selectionEnd;
        if (start > 0) {
            const value = activeInput.value;
            activeInput.value = value.substring(0, start - 1) + value.substring(end);
            activeInput.selectionStart = activeInput.selectionEnd = start - 1;
        }
        activeInput.focus();
    }
}

function showKeyboard() {
    document.getElementById('keyboard').style.display = 'block';
}

function closeKeyboard() {
    document.getElementById('keyboard').style.display = 'none';
}
</script>



    <script>
      function disableButtonOnClick(button) {
          // Desativa o botão para evitar múltiplos cliques
          button.disabled = true;
          // Opcional: Alterar o texto do botão para indicar o envio
          button.textContent = 'Enviando...';
          // Retorna true para permitir o envio do formulário
          return true;
      }
  </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elemsDropdown = document.querySelectorAll('.dropdown-trigger');
            M.Dropdown.init(elemsDropdown, { coverTrigger: false, constrainWidth: false });

            var elemsSidenav = document.querySelectorAll('#slide-out');
            var instancesSidenav = M.Sidenav.init(elemsSidenav, { edge: 'left' });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="<?php echo e(asset('js/chart.js')); ?>" ></script>
    <script src="<?php echo e(asset('js/main.js')); ?>"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems);
    });
</script>



    <?php echo $__env->yieldPushContent('graficos'); ?>

    <div class="keyboard-container" id="keyboard">
    <div class="row">
        <button onclick="insertChar('1')">1</button>
        <button onclick="insertChar('2')">2</button>
        <button onclick="insertChar('3')">3</button>
    </div>
    <div class="row">
        <button onclick="insertChar('4')">4</button>
        <button onclick="insertChar('5')">5</button>
        <button onclick="insertChar('6')">6</button>
    </div>
    <div class="row">
        <button onclick="insertChar('7')">7</button>
        <button onclick="insertChar('8')">8</button>
        <button onclick="insertChar('9')">9</button>
    </div>
    <div class="row">
        <button onclick="insertChar('0')">0</button>
        <button onclick="backspace()">←</button>
        <button class="keyboard-close" onclick="closeKeyboard()">Fechar</button>
    </div>
</div>


</body>
</html><?php /**PATH C:\laragon\www\ordem_servico\resources\views/os/layout.blade.php ENDPATH**/ ?>