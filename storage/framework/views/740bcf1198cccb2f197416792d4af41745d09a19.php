<?php
    $isInput ??= true
?>
<?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($name === '[]'): ?>
        <?php
            $description = "The request body is an array (<code>{$field['type']}</code>`)";
            $description .= !empty($field['description']) ? ", representing ".lcfirst($field['description'])."." : '.';
        ?>
        <p>
            <?php echo Parsedown::instance()->text($description); ?>

        </p>
        <?php $__currentLoopData = $field['__fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subfieldName => $subfield): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!empty($subfield['__fields'])): ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'scribe::components.nested-fields','data' => ['fields' => [$subfieldName => $subfield],'endpointId' => $endpointId,'isInput' => $isInput]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('scribe::nested-fields'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([$subfieldName => $subfield]),'endpointId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($endpointId),'isInput' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isInput)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php else: ?>
                    <p>
                        <?php $__env->startComponent('scribe::components.field-details', [
                          'name' => $subfield['name'],
                          'type' => $subfield['type'] ?? 'string',
                          'required' => $subfield['required'] ?? false,
                          'description' => $subfield['description'] ?? '',
                          'example' => $subfield['example'] ?? '',
                          'endpointId' => $endpointId,
                          'hasChildren' => false,
                          'component' => 'body',
                          'isInput' => $isInput,
                        ]); ?>
                        <?php echo $__env->renderComponent(); ?>
                    </p>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php elseif(!empty($field['__fields'])): ?>
        <p>
        <details>
            <summary style="padding-bottom: 10px;">
                <?php $__env->startComponent('scribe::components.field-details', [
                  'name' => $field['name'],
                  'type' => $field['type'] ?? 'string',
                  'required' => $field['required'] ?? false,
                  'description' => $field['description'] ?? '',
                  'example' => $field['example'] ?? '',
                  'endpointId' => $endpointId,
                  'hasChildren' => true,
                  'component' => 'body',
                  'isInput' => $isInput,
                ]); ?>
                <?php echo $__env->renderComponent(); ?>
            </summary>
            <?php $__currentLoopData = $field['__fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subfieldName => $subfield): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!empty($subfield['__fields'])): ?>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'scribe::components.nested-fields','data' => ['fields' => [$subfieldName => $subfield],'endpointId' => $endpointId,'isInput' => $isInput]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('scribe::nested-fields'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['fields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([$subfieldName => $subfield]),'endpointId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($endpointId),'isInput' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isInput)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                <?php else: ?>
                    <p>
                        <?php $__env->startComponent('scribe::components.field-details', [
                          'name' => $subfield['name'],
                          'type' => $subfield['type'] ?? 'string',
                          'required' => $subfield['required'] ?? false,
                          'description' => $subfield['description'] ?? '',
                          'example' => $subfield['example'] ?? '',
                          'endpointId' => $endpointId,
                          'hasChildren' => false,
                          'component' => 'body',
                          'isInput' => $isInput,
                        ]); ?>
                        <?php echo $__env->renderComponent(); ?>
                    </p>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </details>
        </p>
    <?php else: ?>
        <p>
            <?php $__env->startComponent('scribe::components.field-details', [
              'name' => $field['name'],
              'type' => $field['type'] ?? 'string',
              'required' => $field['required'] ?? false,
              'description' => $field['description'] ?? '',
              'example' => $field['example'] ?? '',
              'endpointId' => $endpointId,
              'hasChildren' => false,
              'component' => 'body',
              'isInput' => $isInput,
            ]); ?>
            <?php echo $__env->renderComponent(); ?>
        </p>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\Projects\needhelp\vendor\knuckleswtf\scribe\src/../resources/views//components/nested-fields.blade.php ENDPATH**/ ?>