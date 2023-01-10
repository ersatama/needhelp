<?php
    use Carbon\Carbon;
?>
<?php if($question->{\App\Domain\Contracts\Contract::IS_PAID}): ?>
    <?php if($question->{\App\Domain\Contracts\Contract::STATUS} === 2): ?>
        <div class="row">
            <div class="col-8">
                <div class="card text-white bg-success">
                    <div class="card-header">
                        <span class="text-muted"><?php if($question->{\App\Domain\Contracts\Contract::IS_IMPORTANT}): ?> <span class="font-weight-bold"><u>Срочный вопрос</u></span> <?php else: ?> Вопрос <?php endif; ?> #<?php echo e($question->{\App\Domain\Contracts\Contract::ID}); ?> • <?php echo e(Carbon::createFromTimeStamp(strtotime($question->{\App\Domain\Contracts\Contract::CREATED_AT}))->diffForHumans()); ?></span> • <a href="/user/<?php echo e($user->{\App\Domain\Contracts\Contract::ID}); ?>/show" class="card-link text-white"><u><?php echo e($user->{\App\Domain\Contracts\Contract::NAME}); ?> <?php echo e($user->{\App\Domain\Contracts\Contract::SURNAME}); ?></u></a> • <span class="text-muted">Отвечено</span><?php if($question->{\App\Domain\Contracts\Contract::PAYMENT_ID}): ?> • <span class="text-muted"><?php echo e($question->{\App\Domain\Contracts\Contract::PAYMENT_ID}); ?></span> <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title"><?php echo e($question->{\App\Domain\Contracts\Contract::DESCRIPTION}); ?></h6>
                        <p class="card-text font-weight-bold"><?php echo e($question->{\App\Domain\Contracts\Contract::ANSWER}); ?></p>
                    </div>
                    <div class="card-footer text-white">
                        <span class="text-muted"><?php echo e(Carbon::createFromTimeStamp(strtotime($question->{\App\Domain\Contracts\Contract::ANSWERED_AT}))->diffForHumans()); ?></span> • <a href="/lawyer/<?php echo e($lawyer->{\App\Domain\Contracts\Contract::ID}); ?>/show" class="card-link text-white"><u><?php echo e($lawyer->{\App\Domain\Contracts\Contract::NAME}); ?> <?php echo e($lawyer->{\App\Domain\Contracts\Contract::SURNAME}); ?></u></a> • <?php echo e($question->{\App\Domain\Contracts\Contract::PRICE}); ?> KZT
                    </div>
                </div>
            </div>
        </div>
    <?php elseif($question->{\App\Domain\Contracts\Contract::STATUS} === 1): ?>
        <div class="row">
            <div class="col-8">
                <div class="card text-white bg-info">
                    <div class="card-header">
                        <span class="text-muted"><?php if($question->{\App\Domain\Contracts\Contract::IS_IMPORTANT}): ?> <span class="font-weight-bold"><u>Срочный вопрос</u></span> <?php else: ?> Вопрос <?php endif; ?> #<?php echo e($question->{\App\Domain\Contracts\Contract::ID}); ?> • <?php echo e(Carbon::createFromTimeStamp(strtotime($question->{\App\Domain\Contracts\Contract::CREATED_AT}))->diffForHumans()); ?></span> • <a href="/user/<?php echo e($user->{\App\Domain\Contracts\Contract::ID}); ?>/show" class="card-link text-white"><u><?php echo e($user->{\App\Domain\Contracts\Contract::NAME}); ?> <?php echo e($user->{\App\Domain\Contracts\Contract::SURNAME}); ?></u></a> • <span class="text-muted">Ждет ответа</span><?php if($question->{\App\Domain\Contracts\Contract::PAYMENT_ID}): ?> • <span class="text-muted"><?php echo e($question->{\App\Domain\Contracts\Contract::PAYMENT_ID}); ?></span> <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title"><?php echo e($question->{\App\Domain\Contracts\Contract::DESCRIPTION}); ?></h6>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif($question->{\App\Domain\Contracts\Contract::STATUS} === 0): ?>
        <div class="row">
            <div class="col-8">
                <div class="card text-white bg-danger">
                    <div class="card-header">
                        <span class="text-muted"><?php if($question->{\App\Domain\Contracts\Contract::IS_IMPORTANT}): ?> <span class="font-weight-bold"><u>Срочный вопрос</u></span> <?php else: ?> Вопрос <?php endif; ?> #<?php echo e($question->{\App\Domain\Contracts\Contract::ID}); ?> • <?php echo e(Carbon::createFromTimeStamp(strtotime($question->{\App\Domain\Contracts\Contract::CREATED_AT}))->diffForHumans()); ?></span> • <a href="/user/<?php echo e($user->{\App\Domain\Contracts\Contract::ID}); ?>/show" class="card-link text-white"><u><?php echo e($user->{\App\Domain\Contracts\Contract::NAME}); ?> <?php echo e($user->{\App\Domain\Contracts\Contract::SURNAME}); ?></u></a> • <span class="text-muted">отменен</span><?php if($question->{\App\Domain\Contracts\Contract::PAYMENT_ID}): ?> • <span class="text-muted"><?php echo e($question->{\App\Domain\Contracts\Contract::PAYMENT_ID}); ?></span> <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title"><?php echo e($question->{\App\Domain\Contracts\Contract::DESCRIPTION}); ?></h6>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

<?php else: ?>
    <div class="row">
        <div class="col-8">
            <div class="card bg-light text-dark">
                <div class="card-header">
                    <span class="text-muted"><?php if($question->{\App\Domain\Contracts\Contract::IS_IMPORTANT}): ?> <span class="font-weight-bold"><u>Срочный вопрос</u></span> <?php else: ?> Вопрос <?php endif; ?> #<?php echo e($question->{\App\Domain\Contracts\Contract::ID}); ?> • <?php echo e(Carbon::createFromTimeStamp(strtotime($question->{\App\Domain\Contracts\Contract::CREATED_AT}))->diffForHumans()); ?></span> • <a href="/user/<?php echo e($user->{\App\Domain\Contracts\Contract::ID}); ?>/show" class="card-link text-dark"><u><?php echo e($user->{\App\Domain\Contracts\Contract::NAME}); ?> <?php echo e($user->{\App\Domain\Contracts\Contract::SURNAME}); ?></u></a> • <span class="text-muted">не оплачено</span><?php if($question->{\App\Domain\Contracts\Contract::PAYMENT_ID}): ?> • <span class="text-muted"><?php echo e($question->{\App\Domain\Contracts\Contract::PAYMENT_ID}); ?></span> <?php endif; ?>
                </div>
                <div class="card-body">
                    <h6 class="card-title"><?php echo e($question->{\App\Domain\Contracts\Contract::DESCRIPTION}); ?></h6>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\Projects\needhelp\resources\views/vendor/backpack/base/crud/card.blade.php ENDPATH**/ ?>