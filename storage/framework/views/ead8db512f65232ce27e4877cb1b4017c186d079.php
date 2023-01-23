<?php
    $connected_entity = new $field['model'];
    $connected_entity_key_name = $connected_entity->getKeyName();
    $field['multiple'] = $field['multiple'] ?? $crud->relationAllowsMultiple($field['relation_type']);
    $field['attribute'] = $field['attribute'] ?? $connected_entity->identifiableAttribute();
    $field['include_all_form_fields'] = $field['include_all_form_fields'] ?? true;
    $field['allows_null'] = $field['allows_null'] ?? $crud->model::isColumnNullable($field['name']);
    // Note: isColumnNullable returns true if column is nullable in database, also true if column does not exist.

    // this field can be used as a pivot select for n-n relationships
    $field['is_pivot_select'] = $field['is_pivot_select'] ?? false;

    if (!isset($field['options'])) {
            $field['options'] = $connected_entity::all()->pluck($field['attribute'],$connected_entity_key_name);
        } else {
            $field['options'] = call_user_func($field['options'], $field['model']::query())->pluck($field['attribute'],$connected_entity_key_name);
    }

    // make sure the $field['value'] takes the proper value
    $current_value = old_empty_or_null($field['name'], []) ??  $field['value'] ?? $field['default'] ?? [];

    if (!empty($current_value) || is_int($current_value)) {
        switch (gettype($current_value)) {
            case 'array':
                $current_value = $connected_entity
                                    ->whereIn($connected_entity_key_name, $current_value)
                                    ->get()
                                    ->pluck($field['attribute'], $connected_entity_key_name);
                break;

            case 'object':
                if (is_subclass_of(get_class($current_value), 'Illuminate\Database\Eloquent\Model') ) {
                    $current_value = [$current_value->{$connected_entity_key_name} => $current_value->{$field['attribute']}];
                }else{
                    $current_value = $current_value
                                    ->pluck($field['attribute'], $connected_entity_key_name);
                    }
            break;

            case 'NULL':
                $current_value = [];

            default:
                $current_value = $connected_entity
                                ->where($connected_entity_key_name, $current_value)
                                ->get()
                                ->pluck($field['attribute'], $connected_entity_key_name);
                break;
        }
    }

    $current_value = !is_array($current_value) ? $current_value->toArray() : $current_value;

?>

<?php echo $__env->make('crud::fields.inc.wrapper_start', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <label><?php echo $field['label']; ?></label>
    
    <?php if($field['multiple']): ?><input type="hidden" name="<?php echo e($field['name']); ?>" value="" <?php if(in_array('disabled', $field['attributes'] ?? [])): ?> disabled <?php endif; ?> /><?php endif; ?>
    <select
        style="width:100%"
        name="<?php echo e($field['name'].($field['multiple']?'[]':'')); ?>"
        data-init-function="bpFieldInitRelationshipSelectElement"
        data-field-is-inline="<?php echo e(var_export($inlineCreate ?? false)); ?>"
        data-column-nullable="<?php echo e(var_export($field['allows_null'])); ?>"
        data-placeholder="<?php echo e($field['placeholder']); ?>"
        data-field-multiple="<?php echo e(var_export($field['multiple'])); ?>"
        data-language="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
        data-is-pivot-select=<?php echo e(var_export($field['is_pivot_select'])); ?>

        bp-field-main-input
        <?php echo $__env->make('crud::fields.inc.attributes', ['default_class' =>  'form-control'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php if($field['multiple']): ?>
        multiple
        <?php endif; ?>
        >

        <?php if($field['allows_null'] && !$field['multiple']): ?>
            <option value="">-</option>
        <?php endif; ?>

        <?php if(count($field['options'])): ?>
            <?php $__currentLoopData = $field['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $selected = '';
                if(!empty($current_value)) {
                    if(in_array($key, array_keys($current_value))) {
                        $selected = 'selected';
                    }
                }
            ?>
                    <option value="<?php echo e($key); ?>" <?php echo e($selected); ?>><?php echo e($option); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </select>

    
    <?php if(isset($field['hint'])): ?>
        <p class="help-block"><?php echo $field['hint']; ?></p>
    <?php endif; ?>
<?php echo $__env->make('crud::fields.inc.wrapper_end', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>





<?php $__env->startPush('crud_fields_styles'); ?>
    
    <?php Assets::echoCss('packages/select2/dist/css/select2.min.css'); ?>
    <?php Assets::echoCss('packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css'); ?>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('crud_fields_scripts'); ?>
    
    <?php Assets::echoJs('packages/select2/dist/js/select2.full.min.js'); ?>
    <?php if(app()->getLocale() !== 'en'): ?>
        <?php Assets::echoJs('packages/select2/dist/js/i18n/' . str_replace('_', '-', app()->getLocale()) . '.js'); ?>
    <?php endif; ?>

<?php if(! Assets::isLoaded('bpFieldInitRelationshipSelectElement')) { Assets::markAsLoaded('bpFieldInitRelationshipSelectElement');  ?>
<script>
    // if nullable, make sure the Clear button uses the translated string
    document.styleSheets[0].addRule('.select2-selection__clear::after','content:  "<?php echo e(trans('backpack::crud.clear')); ?>";');


    /**
     *
     * This method gets called automatically by Backpack:
     *
     * @param  node element The jQuery-wrapped "select" element.
     * @return void
     */
    function bpFieldInitRelationshipSelectElement(element) {
        var $placeholder = element.attr('data-placeholder');
        var $multiple = element.attr('data-field-multiple')  == 'false' ? false : true;
        var $allows_null = (element.attr('data-column-nullable') == 'true') ? true : false;
        var $allowClear = $allows_null;
        var $isFieldInline = element.data('field-is-inline');
        var $isPivotSelect = element.data('is-pivot-select');
        
        const changePivotOptionState = function(pivotSelector, enable = true) {
            let containerName = getPivotContainerName(pivotSelector);
            let pivotsContainer = pivotSelector.closest('div[data-repeatable-holder="'+containerName+'"]');
            
            $(pivotsContainer).children().each(function(i,container) {
                $(container).find('select').each(function(i, el) {
                    
                    if(typeof $(el).attr('data-is-pivot-select') !== 'undefined' && $(el).attr('data-is-pivot-select')) {
                        if(pivotSelector.val()) {
                            if(enable) {
                                $(el).find('option[value="'+pivotSelector.val()+'"]').prop('disabled',false);   
                            }else{
                                if($(el).val() !== pivotSelector.val()) {
                                    $(el).find('option[value="'+pivotSelector.val()+'"]').prop('disabled',true);
                                }
                            }
                        }
                    }
                });
            });
        };

        const getPivotContainerName = function(pivotSelector) {
            let containerName = pivotSelector.data('repeatable-input-name')
            return containerName.substring(0, containerName.indexOf('['));
        }

        const disablePreviouslySelectedPivots = function(pivotSelector) {
            
            let containerName = getPivotContainerName(pivotSelector);
            let pivotsContainer = pivotSelector.closest('div[data-repeatable-holder="'+containerName+'"]');

            let selectedValues = [];
            let selectInputs = [];
            
            $(pivotsContainer).children().each(function(i,container) {
                $(container).find('select').each(function(i, el) {
                    if(typeof $(el).attr('data-is-pivot-select') !== 'undefined' && $(el).attr('data-is-pivot-select') != "false") {
                        selectInputs.push(el);
                        if($(el).val()) {
                            selectedValues.push($(el).val());
                        }
                    }
                });
            });

            selectInputs.forEach(function(input) {
                selectedValues.forEach(function(value) {
                    if(value !== $(input).val()) {
                        $(input).find('option[value="'+value+'"]').prop('disabled',true);
                    }
                });
            });
        };

        var $select2Settings = {
                theme: 'bootstrap',
                multiple: $multiple,
                placeholder: $placeholder,
                allowClear: $allowClear,
                dropdownParent: $isFieldInline ? $('#inline-create-dialog .modal-content') : $(document.body)
            };
        if (!$(element).hasClass("select2-hidden-accessible"))
        {
            $(element).select2($select2Settings);
            
            if($isPivotSelect) {
                disablePreviouslySelectedPivots($(element));
            }
        }

        if($isPivotSelect) {
            $(element).on('select2:selecting', function(e) {
                if($(this).val()) {
                    changePivotOptionState($(this)); 
                }
                return true;
            });

            $(element).on('select2:select', function(e) {
                changePivotOptionState($(this), false);
                return true;
            });

            $(element).on('CrudField:delete', function(e) {
                changePivotOptionState($(this));
                return true;
            });
        }

    }
</script>
<?php } ?>
<?php $__env->stopPush(); ?>


<?php /**PATH C:\Projects\needhelp\vendor\backpack\pro\src/../resources/views/fields/relationship/select.blade.php ENDPATH**/ ?>