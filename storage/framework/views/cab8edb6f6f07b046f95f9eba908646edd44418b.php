<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-4">
            <h3 class="text-center mb-4"><?php echo e(trans('backpack::base.login')); ?></h3>
            <div class="card">
                <div class="card-body px-2">
                    <form class="col-md-12 p-t-10" role="form" method="POST" action="<?php echo e(route('backpack.auth.login')); ?>">
                        <?php echo csrf_field(); ?>


                        <?php if($username): ?>
                            <div class="form-group">
                                <label class="control-label" for="<?php echo e($username); ?>"><?php echo e(config('backpack.base.authentication_column_name')); ?></label>

                                <div>
                                    <input type="text" class="form-control<?php echo e($errors->has($username) ? ' is-invalid' : ''); ?>" name="<?php echo e($username); ?>" value="<?php echo e(old($username)); ?>" id="<?php echo e($username); ?>">

                                    <?php if($errors->has($username)): ?>
                                        <span class="invalid-feedback">
                                        <strong><?php echo e($errors->first($username)); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label class="control-label" for="password"><?php echo e(trans('backpack::base.password')); ?></label>

                            <div>
                                <input type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password" id="password">

                                <?php if($errors->has('password')): ?>
                                    <span class="invalid-feedback">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> <?php echo e(trans('backpack::base.remember_me')); ?>

                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <div class="g-recaptcha" data-sitekey="<?php echo e(env('GOOGLE_RECAPTCHA_KEY')); ?>" data-type="image"></div>
                                <?php if($errors->has('g-recaptcha-response')): ?>
                                    <span class="invalid-feedback">
                                        <strong><?php echo e($errors->first('g-recaptcha-response')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-block btn-primary">
                                    <?php echo e(trans('backpack::base.login')); ?>

                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(backpack_view('layouts.plain'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Projects\needhelp\resources\views/vendor/backpack/base/auth/login.blade.php ENDPATH**/ ?>