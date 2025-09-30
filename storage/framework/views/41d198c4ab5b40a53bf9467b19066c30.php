
<?php $__env->startSection('title','Detalhes da Ordem de Serviço'); ?>
<?php $__env->startSection('conteudo'); ?>


<div class="row">

<?php if($isAdmin): ?>
<div class="col s12 m8 offset-m2">
    <div class="card">
        <div class="card-content">
            <span class="card-title center"><b>Atribuir Ordem de Serviço</b></span>
            <p class='center'>Atenção <b class="red-text center">Administrador</b>, atribua a O.S. a um funcionário inserindo o número da matricula.</p>

            <form method="POST" action="<?php echo e(route('os.assign', ['codord' => $ordem->ORDEM, 'sequen' => $ordem->SEQUENCIA, 'codire' => $ordem->Cod_Item])); ?>">
                <?php echo csrf_field(); ?>

                <div class="input-field">
                    <input type="text" name="matricula" id="matricula" required>
                    <label for="matricula">Digite a Matrícula do Funcionário</label>
                </div>

                <div class="center">
                    <button type="submit" class="btn blue btn-large">Atribuir O.S.</button>
                </div>
            </form>

        </div>
    </div>
</div>
<?php endif; ?>
<div class="col s12 m8 offset-m2">
    <div class="card">
        <div class="card-content">
            <span class="card-title center"><b>Situação da Ordem de Serviço</b></span>
            <div style="margin: 30px 0;">
                <p><b>Status:</b> <?php echo e($ordem->status); ?></p>

                <div class="progress">
                    <div class="determinate <?php echo e($ordem->progress_color); ?>" style="width: <?php echo e($ordem->progress); ?>%"></div>
                </div>
            </div>

        </div>
    </div>
</div>

    <div class="col s12 m8 offset-m2">
        <div class="card">
            <div class="card-content">
                <span class="card-title center"><b>Detalhes da Ordem de Serviço</b></span>
                <p><b>Ordem:</b> <?php echo e($ordem->ORDEM); ?></p>
                <p><b>Filial:</b> <?php echo e($ordem->FILIAL); ?></p>
                <p><b>Matrícula:</b> <?php echo e($ordem->MATRICULA); ?></p>
                <p><b>Placa:</b> <?php echo e($ordem->PLACA); ?></p>
                <p><b>Criado:</b> <?php echo e($ordem->CRIADO); ?></p>
                <p><b>Previsão:</b> <?php echo e($ordem->PREVISAO); ?></p>
                <p><b>Autorizado:</b> <?php echo e($ordem->AUTORIZADO); ?></p>
                <p><b>Cód. Item:</b> <?php echo e($ordem->Cod_Item); ?></p>
                <p><b>Sequência:</b> <?php echo e($ordem->SEQUENCIA); ?></p>
                <p><b>Item Revisional:</b> <?php echo e($ordem->Item_Revisional); ?></p>
                <p><b>Manutenção:</b> <?php echo e($ordem->MANUTENCAO); ?></p>
                <p><b>Criado por:</b> <?php echo e($ordem->Criado_por); ?></p><br>


                <div class="center">
                    <?php if($ordem->status == 'Pendente'): ?>
                        <form method="POST" action="<?php echo e(route('os.start', ['codord' => $ordem->ORDEM, 'sequen' => $ordem->SEQUENCIA, 'codire' => $ordem->Cod_Item])); ?>" style="display:inline">
                            <?php echo csrf_field(); ?>
                            <button class="btn-large green">Iniciar Serviço</button>
                        </form>
                    <?php endif; ?>
                    <?php if($ordem->status != 'Finalizada' && $ordem->status != 'Pendente' && $ordem->status != 'Em Pausa'): ?>
                            <form method="POST" action="<?php echo e(route('os.finish', ['codord' => $ordem->ORDEM, 'sequen' => $ordem->SEQUENCIA, 'codire' => $ordem->Cod_Item])); ?>" style="display:inline">
                                <?php echo csrf_field(); ?>
                                <button class="btn-large red">Finalizar Serviço</button>
                            </form>
                    <?php endif; ?>
                    
                </div>

            </div>
        </div>
    </div>
    <?php if($ordem->status != 'Finalizada'): ?>

    <?php if($assignment && $assignment->start_time && !$assignment->end_time): ?>

    <div class="col s12 m8 offset-m2">
        <div class="card">
            <div class="card-content">
                    <div class='center'>


                    
                    <?php if($assignment && $assignment->pauses->whereNull('end_time')->count()): ?>

                        <?php $__currentLoopData = $assignment->pauses->whereNull('end_time'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pause): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <form method="POST" action="<?php echo e(route('os.resume', ['codord' => $ordem->ORDEM, 'sequen' => $ordem->SEQUENCIA, 'codire' => $ordem->Cod_Item])); ?>" style="display:inline">
                                <?php echo csrf_field(); ?>
                                <button class="btn-large blue">Finalizar Pausa</button>
                            </form>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <form method="POST" action="<?php echo e(route('os.pause', ['codord' => $ordem->ORDEM, 'sequen' => $ordem->SEQUENCIA, 'codire' => $ordem->Cod_Item])); ?>" style="display:inline">
                        <?php echo csrf_field(); ?>
                        <div class="input-field" style="width:200px; display:inline-block; margin-right:10px;">
                            <input type="text" name="reason_code" id="reason_code" required>
                            <label for="reason_code">Código do Motivo</label>
                        </div>

                        <button class="btn-large orange" type="submit">Iniciar Pausa</button>
                    </form>
                    <?php endif; ?>
</div>

                    <!-- Lista de motivos fixos -->
                    <div style="margin-top:10px; text-align:left;">
                        <p><b>Motivos de Pausa:</b></p>
                        <ul class="collection">
                            <li class="collection-item">01 - Almoço</li>
                            <li class="collection-item">02 - Falta de peça</li>
                            <li class="collection-item">03 - Manutenção de máquina</li>
                            <li class="collection-item">04 - Espera técnica</li>
                            <li class="collection-item">05 - Outro motivo</li>
                        </ul>
                    </div>




                





            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('os.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ordem_servico\resources\views/os/details.blade.php ENDPATH**/ ?>