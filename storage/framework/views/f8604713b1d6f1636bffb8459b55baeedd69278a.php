    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <?php if(config('backpack.base.meta_robots_content')): ?><meta name="robots" content="<?php echo e(config('backpack.base.meta_robots_content', 'noindex, nofollow')); ?>"> <?php endif; ?>

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" /> 
    <title><?php echo e(isset($title) ? $title.' :: '.config('backpack.base.project_name') : config('backpack.base.project_name')); ?></title>

    <?php echo $__env->yieldContent('before_styles'); ?>
    <?php echo $__env->yieldPushContent('before_styles'); ?>

    <?php if(config('backpack.base.styles') && count(config('backpack.base.styles'))): ?>
        <?php $__currentLoopData = config('backpack.base.styles'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset($path).'?v='.config('backpack.base.cachebusting_string')); ?>">
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <?php if(config('backpack.base.mix_styles') && count(config('backpack.base.mix_styles'))): ?>
        <?php $__currentLoopData = config('backpack.base.mix_styles'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $path => $manifest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <link rel="stylesheet" type="text/css" href="<?php echo e(mix($path, $manifest)); ?>">
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <?php if(config('backpack.base.vite_styles') && count(config('backpack.base.vite_styles'))): ?>
        <?php echo app('Illuminate\Foundation\Vite')(config('backpack.base.vite_styles')); ?>
    <?php endif; ?>

    <?php echo $__env->yieldContent('after_styles'); ?>
    <?php echo $__env->yieldPushContent('after_styles'); ?>

    
    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        .head-date {
            gap: 15px;
        }
        .input-date {
            cursor: pointer;
            text-align: center;
            width: 100px;
            border-radius: 3px;
            border: none;
            background: rgba(0,0,0,.08);
            font-size: 14px;
            height: 22px;
            outline: none;
        }
    </style>
<?php /**PATH C:\Projects\needhelp\resources\views/vendor/backpack/base/inc/head.blade.php ENDPATH**/ ?>