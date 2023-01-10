<?php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.preview') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
?>

<?php $__env->startSection('header'); ?>
	<section class="container-fluid d-print-none">
    	<a href="javascript: window.print();" class="btn float-right"><i class="la la-print"></i></a>
		<h2>
	        <span class="text-capitalize"><?php echo $crud->getHeading() ?? $crud->entity_name_plural; ?></span>
	        <small><?php echo $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')).' '.$crud->entity_name; ?>.</small>
	        <?php if($crud->hasAccess('list')): ?>
	          <small class=""><a href="<?php echo e(url($crud->route)); ?>" class="font-sm"><i class="la la-angle-double-left"></i> <?php echo e(trans('backpack::crud.back_to_all')); ?> <span><?php echo e($crud->entity_name_plural); ?></span></a></small>
	        <?php endif; ?>
	    </h2>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
	<div class="<?php echo e($crud->getShowContentClass()); ?>">


	  <div class="">
	  	<?php if($crud->model->translationEnabled()): ?>
			<div class="row">
				<div class="col-md-12 mb-2">

					<div class="btn-group float-right">
					<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php echo e(trans('backpack::crud.language')); ?>: <?php echo e($crud->model->getAvailableLocales()[request()->input('_locale')?request()->input('_locale'):App::getLocale()]); ?> &nbsp; <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<?php $__currentLoopData = $crud->model->getAvailableLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $locale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<a class="dropdown-item" href="<?php echo e(url($crud->route.'/'.$entry->getKey().'/show')); ?>?_locale=<?php echo e($key); ?>"><?php echo e($locale); ?></a>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</ul>
					</div>
				</div>
			</div>
	    <?php endif; ?>
	    <div class="card no-padding no-border">
			<table class="table table-striped mb-0">
		        <tbody>
		        <?php $__currentLoopData = $crud->columns(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		            <tr>
		                <td>
		                    <strong><?php echo $column['label']; ?>:</strong>
		                </td>
                        <td>
                        	<?php
                        		// create a list of paths to column blade views
                        		// including the configured view_namespaces
                        		$columnPaths = array_map(function($item) use ($column) {
                        			return $item.'.'.$column['type'];
                        		}, \Backpack\CRUD\ViewNamespaces::getFor('columns'));

                        		// but always fall back to the stock 'text' column
                        		// if a view doesn't exist
                        		if (!in_array('crud::columns.text', $columnPaths)) {
                        			$columnPaths[] = 'crud::columns.text';
                        		}
                        	?>
													<?php echo $__env->first($columnPaths, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </td>
		            </tr>
		        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php if($crud->buttons()->where('stack', 'line')->count()): ?>
					<tr>
						<td><strong><?php echo e(trans('backpack::crud.actions')); ?></strong></td>
						<td>
							<?php echo $__env->make('crud::inc.button_stack', ['stack' => 'line'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						</td>
					</tr>
				<?php endif; ?>
		        </tbody>
			</table>
	    </div>
	  </div>

	</div>
</div>

<?php
    use App\Domain\Repositories\Question\QuestionRepositoryEloquent;
    use App\Domain\Repositories\User\UserRepositoryEloquent;
    use Carbon\Carbon;
    use App\Domain\Contracts\Contract;
    $url    =   explode('/',$_SERVER['REQUEST_URI']);
    $questions  =   QuestionRepositoryEloquent::_getByUserId($url[2]);
?>
<h4>Вопросы (<?php echo e(sizeof($questions)); ?>)</h4>
<?php
    $user   =   UserRepositoryEloquent::_getById($url[2]);
    $status =   [
        'отменен',
        'Ждет ответа',
        'Отвечено'
    ];
?>
<div class="row">
    <div class="col-8">
        <table class="table bg-white table-bordered text-small">
            <thead>
                <tr>
                    <th scope="col" class="fsize">ID</th>
                    <th scope="col" class="fsize">Статус</th>
                    <th scope="col" class="fsize">Вопрос</th>
                    <th scope="col" class="fsize">Ответ</th>
                    <th scope="col" class="fsize">Юрист</th>
                </tr>
            </thead>
            <tbody>

                <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as &$question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $lawyer =   UserRepositoryEloquent::_getById($question->{Contract::LAWYER_ID});
                    ?>
                    <tr>
                        <th scope="row" class="fsize"><?php echo e($question->{Contract::ID}); ?></th>
                        <td class="fsize">
                            <?php if($question->{Contract::IS_IMPORTANT}): ?> <div class="text-danger">Срочный</div> <?php endif; ?>
                            <?php if($question->{Contract::IS_PAID}): ?>
                                <div class="<?php if($question->{Contract::STATUS} === 2): ?> bg-success <?php elseif($question->{Contract::STATUS} === 1): ?> bg-info <?php else: ?> bg-danger <?php endif; ?> rounded text-center mb-2"><?php echo e($status[$question->{Contract::STATUS}]); ?></div>
                                <?php if($question->{Contract::PAYMENT_ID}): ?> <div class="font-weight-bold"><?php echo e($question->{Contract::PAYMENT_ID}); ?></div> <?php endif; ?>
                            <?php else: ?>
                                    <div class="bg-secondary rounded text-center mb-2">Не оплачено</div>
                            <?php endif; ?>
                            <?php if($question->{Contract::PRICE} > 0): ?> <div class="font-weight-bold text-success"><?php echo e($question->{Contract::PRICE}); ?> kzt</div> <?php endif; ?>
                        </td>
                        <td class="fsize" width="33%">
                            <div class="text-info font-weight-bold border-bottom pb-2 mb-2"><?php echo e(Carbon::createFromTimeStamp(strtotime($question->{Contract::CREATED_AT}))->diffForHumans()); ?></div>
                            <?php echo e($question->{Contract::DESCRIPTION}); ?>

                        </td>
                        <td class="fsize" width="33%">
                            <?php if($question->{Contract::STATUS} === 2): ?>
                                <div class="text-info font-weight-bold border-bottom pb-2 mb-2"><?php echo e(Carbon::createFromTimeStamp(strtotime($question->{Contract::ANSWERED_AT}))->diffForHumans()); ?></div>
                            <?php endif; ?>
                            <?php echo e($question->{Contract::ANSWER}); ?>

                        </td>
                        <td class="fsize">
                            <?php if($lawyer): ?>
                                <?php if($lawyer->{Contract::ROLE} === Contract::LAWYER): ?>
                                    <a href="/lawyer/<?php echo e($lawyer->{Contract::ID}); ?>/show" class="text-info"><u><?php echo e($lawyer->{Contract::NAME}); ?> <?php echo e($lawyer->{Contract::SURNAME}); ?></u></a>
                                <?php elseif($lawyer->{Contract::ROLE} === Contract::ADMIN): ?>
                                    <a href="/admin/<?php echo e($lawyer->{Contract::ID}); ?>/show" class="text-info"><u><?php echo e($lawyer->{Contract::NAME}); ?> <?php echo e($lawyer->{Contract::SURNAME}); ?></u></a>
                                <?php elseif($lawyer->{Contract::ROLE} === Contract::USER): ?>
                                    <a href="/user/<?php echo e($lawyer->{Contract::ID}); ?>/show" class="text-info"><u><?php echo e($lawyer->{Contract::NAME}); ?> <?php echo e($lawyer->{Contract::SURNAME}); ?></u></a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<style>
    .fsize {
        font-size: 12px;
    }
</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make(backpack_view('blank'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Projects\needhelp\resources\views/vendor/backpack/base/crud/user/show.blade.php ENDPATH**/ ?>
