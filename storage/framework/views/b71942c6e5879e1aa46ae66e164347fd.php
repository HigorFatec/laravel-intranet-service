
<?php $__env->startSection('title','Ordem de Serviço'); ?>
<?php $__env->startSection('conteudo'); ?>


<div class="row login-container">
    <div class="col s12 m6 offset-m3">
        
        <?php if($message = Session::get('success')): ?>
        <div class="alerta card">
            <span class="card-title">Logout</span>
            <p><?php echo e($message); ?></p>
        </div>
        <?php endif; ?>

        <?php if($mensagem = Session::get('erro')): ?>
        <div class="erro">
            <strong>Erro:</strong> <?php echo e($mensagem); ?>

        </div>
        <?php endif; ?>

        
        <div class="card card-login">
            <div class="card-content">
                <span class="card-title card-title-login">Login</span>

                <?php if($errors->any()): ?>
                    <div class="erro">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            • <?php echo e($error); ?><br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('login.post')); ?>">
                    <?php echo csrf_field(); ?>

                    <label for="matricula">Matrícula</label>
                    <input type="text" name="matricula" id="matricula" required>

                    <label for="password">Senha (somente para administradores)</label>
                    <input type="password" name="password" id="password">

                    <button type="submit" class="btn-cadastrar">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('os.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ordem_servico\resources\views/auth/login.blade.php ENDPATH**/ ?>