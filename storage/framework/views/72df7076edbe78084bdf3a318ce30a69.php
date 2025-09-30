<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>teste</h1>
    <tbody>
    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($user->CODFUN); ?>,</td>
            <td><?php echo e($user->NOMFUN); ?>,</td>
            <td><?php echo e($user->DATINC); ?>,</td>
        </tr>
        <br>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
</body>
</html><?php /**PATH C:\laragon\www\ordem_servico\resources\views/index.blade.php ENDPATH**/ ?>