<?php if(count($errors) > 0): ?>
<ul>       
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="alert alert-danger">
            <li><?php echo e($e); ?></li>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php endif; ?>


<?php if(Session::has('success')): ?>
    <div class="alert alert-success">
        <?php echo e(Session::get('success')); ?>

        <?php
            Session::forget('success');
        ?>
    </div>
<?php endif; ?>

<?php if(Session::has('error')): ?>
    <div class="alert alert-error">
        <?php echo e(Session::get('error')); ?>

        <?php
            Session::forget('error');
        ?>
    </div>
<?php endif; ?>


<?php if(session()->has('success_msg')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo e(session()->get('success_msg')); ?>

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<?php endif; ?>

<?php if(session()->has('alert_msg')): ?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <?php echo e(session()->get('alert_msg')); ?>

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<?php endif; ?>

<?php /**PATH C:\Users\User\sources\KVA\resources\views/internals/messages.blade.php ENDPATH**/ ?>