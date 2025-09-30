
<?php $__env->startSection('title','Ordem de Serviço'); ?>
<?php $__env->startSection('conteudo'); ?>

<div class="row">
    <div class="col s12 m8 offset-m2">

        <?php if($message = Session::get('success')): ?>
        <div class="card green darken-1">
          <div class="card-content white-text">
            <span class="card-title">Serviço Atualizado</span>
            <p>O serviço foi atualizado com sucesso!
           </p>
          </div>
        </div>
        <?php endif; ?>

        <?php if($message = Session::get('success2')): ?>
        <div class="card green darken-1">
          <div class="card-content white-text">
            <span class="card-title">Serviço Atribuído</span>
            <p>O serviço foi atribuído com sucesso!
           </p>
          </div>
        </div>
        <?php endif; ?>
            <div class="card">
                <div class="card-content">

                                                            


<div class="row" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px; flex-wrap: wrap;">
    
    
    <form method="GET" action="<?php echo e(route('dashboard')); ?>" style="display: flex; align-items: center; gap: 10px; flex: 1; max-width: 150px;">
        <div class="input-field" style="margin: 0; width: 100%;">
            <i class="material-icons prefix" style="color: #184693;">search</i>
            <input type="text" name="ordem" id="ordem" value="<?php echo e(request('ordem')); ?>" class="validate" style="padding-left: 40px; border-bottom: 2px solid #184693;">
            <label for="ordem">Buscar</label>
        </div>
    </form>

    
    <div style="flex: 2; text-align: center;">
        <h4 style="color: #184693; font-weight: bold; margin: 0;">
            <i class="material-icons left" style="font-size: 1.8rem;">assignment</i>
            Serviços Atribuídos
        </h4>
    </div>

</div>






        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Ordem</th>
            
            <th>Placa</th>
            <th>Criado</th>
            <th>Previsão</th>
            
            <th>Cod Item</th>
            <th>Item Revisional</th>
            <th>Manutenção</th>
            <th>Visualizar</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $ordens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ordem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($isAdmin): ?>
                <?php
                    $existe = $assignments->contains(function($item) use ($ordem) {
                        return $item->os_id == $ordem->ORDEM && $item->sequencia == $ordem->SEQUENCIA && $item->codire == $ordem->Cod_Item;
                    });

                ?>
            <?php else: ?>
                <?php
                    $existe = false;
                ?>
            <?php endif; ?>

            <?php if($existe === false ): ?>

            <tr>
                <td><?php echo e($ordem->ORDEM); ?></td>
                
                <td><?php echo e($ordem->PLACA); ?></td>
                <td><?php echo e($ordem->CRIADO); ?></td>
                <td><?php echo e($ordem->PREVISAO); ?></td>
                <td><?php echo e($ordem->Cod_Item); ?></td>
                
                <td><?php echo e($ordem->Item_Revisional); ?></td>
                <td><?php echo e($ordem->MANUTENCAO); ?></td>

                <td>
                    <form action="<?php echo e(route('site.details', ['codord' => $ordem->ORDEM, 'sequen' => $ordem->SEQUENCIA, 'codire' => $ordem->Cod_Item])); ?>" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-primary blue"> <i class="material-icons">visibility</i></button>
                    </form>
                </td>

            </tr>
                <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('os.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ordem_servico\resources\views/os/index.blade.php ENDPATH**/ ?>