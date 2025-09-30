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

    body{
      font-family: 'Montserrat', sans-serif !important;
    }

    .row{
          background-color: #777777; /* Azul claro */
          padding: 20px;
        }

    .red{
      background-color: #184693 !important;
    }    
    .admin{
      /* Modificar a cor do texto*/
      color: #ffffff;
      background-color: #ff0000;
    }
    .custom-image {
    display: block;
    margin-left: auto;
    margin-right: auto;
              /* Se você quiser um tamanho específico, defina largura e altura diretamente */
      max-width: 75px; /* Define a largura máxima da imagem */
      max-height: 75px; /* Define a altura máxima da imagem */
    }


    .custom-image2 {
      width: auto; /* Ajusta a imagem para ocupar 100% da largura do container */
      height: auto; /* Mantém a proporção da imagem */
      /* Se você quiser um tamanho específico, defina largura e altura diretamente */
      max-width: 2050px; /* Define a largura máxima da imagem */
      max-height: 400px; /* Define a altura máxima da imagem */
    }

    .btn-cadastrar {
    background-color: #184693; /* Cor de fundo do botão */
    color: white; /* Cor do texto */
    padding: 10px 20px; /* Espaçamento interno */
    border: none; /* Remover bordas */
    border-radius: 5px; /* Bordas arredondadas */
    cursor: pointer; /* Cursor de mãozinha ao passar o mouse */
    text-align: center; /* Centralizar texto */
    text-decoration: none; /* Remover sublinhado */
    display: inline-block; /* Mostrar como bloco inline */
    font-size: 16px; /* Tamanho da fonte */
}

.btn-cadastrar:hover {
    background-color: #0056b3; /* Cor de fundo ao passar o mouse */
}

.btn-group .btn.active {
    background-color: #ff0000; /* Cor de destaque para o botão ativo */
    color: white;
}


.cards-container {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 20px; /* espaço entre os cards */
}
.cards-container .card {
  width: 200px; /* ou ajuste conforme seu layout */
}

.extra-margin-bottom {
  margin-bottom: 40px; /* ajuste a altura desejada */
}

.rounded-card {
  border-radius: 12px;
  overflow: hidden; /* Importante para que imagens dentro também fiquem arredondadas */
}



/* STYLE PARA BOTAO STATUS */

.progress .determinate {
  transition: width 1s ease-in-out;
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

</body>
</html><?php /**PATH C:\laragon\www\ordem_servico\resources\views/layout.blade.php ENDPATH**/ ?>