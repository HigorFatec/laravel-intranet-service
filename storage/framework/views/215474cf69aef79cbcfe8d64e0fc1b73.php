
<?php $__env->startSection('title','Painel Administrador'); ?>

<?php $__env->startSection('conteudo'); ?>
<div class="row">
    <div class="col s12 m8 offset-m2">
        <div class="card">
            <div class="card-content">


                    <h2>Criar Novo Administrador</h2>

                    <?php if(session('success')): ?>
                        <div style="color: green;"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.create')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                        Matrícula:<br>
                        <input type="text" name="matricula" required><br><br>

                        Senha:<br>
                        <input type="password" name="password" required><br><br>

                        Nível do administrador:<br>
                        <label>
                            <input type="radio" name="admin_level" value="1" checked>
                            <span style="color: black">Administrador Nível 1</span>
                        </label>

                        <label>
                            <input type="radio" name="admin_level" value="2">
                            <span style="color: black">Administrador Nível 2</span>
                        </label>



                        <div class="center">
                            <button class="btn-large " type="submit">Criar Administrador</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('os.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ordem_servico\resources\views/admin/create.blade.php ENDPATH**/ ?>