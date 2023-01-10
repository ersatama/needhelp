
<?php
    $connected_entity = new $field['model'];
    $connected_entity_key_name = $connected_entity->getKeyName();
    $old_value = old_empty_or_null($field['name'], false) ??  $field['value'] ?? $field['default'] ?? false;
    // by default set ajax query delay to 500ms
    // this is the time we wait before send the query to the search endpoint, after the user as stopped typing.
    $field['delay'] = $field['delay'] ?? 500;
    $field['allows_null'] = $field['allows_null'] ?? $crud->model::isColumnNullable($field['name']);
    $field['placeholder'] = $field['placeholder'] ?? trans('backpack::crud.select_entry');
    $field['attribute'] = $field['attribute'] ?? $connected_entity->identifiableAttribute();
    $field['minimum_input_length'] = $field['minimum_input_length'] ?? 2;
?>

<?php echo $__env->make('crud::fields.inc.wrapper_start', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <label><?php echo $field['label']; ?></label>
    <select
        name="<?php echo e($field['name']); ?>"
        style="width: 100%"
        data-init-function="bpFieldInitSelect2FromAjaxElement"
        data-field-is-inline="<?php echo e(var_export($inlineCreate ?? false)); ?>"
        data-column-nullable="<?php echo e(var_export($field['allows_null'])); ?>"
        data-dependencies="<?php echo e(isset($field['dependencies'])?json_encode(Arr::wrap($field['dependencies'])): json_encode([])); ?>"
        data-placeholder="<?php echo e($field['placeholder']); ?>"
        data-minimum-input-length="<?php echo e($field['minimum_input_length']); ?>"
        data-data-source="<?php echo e($field['data_source']); ?>"
        data-method="<?php echo e($field['method'] ?? 'GET'); ?>"
        data-field-attribute="<?php echo e($field['attribute']); ?>"
        data-connected-entity-key-name="<?php echo e($connected_entity_key_name); ?>"
        data-include-all-form-fields="<?php echo e(isset($field['include_all_form_fields']) ? ($field['include_all_form_fields'] ? 'true' : 'false') : 'false'); ?>"
        data-ajax-delay="<?php echo e($field['delay']); ?>"
        data-language="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
        <?php echo $__env->make('crud::fields.inc.attributes', ['default_class' =>  'form-control'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        >

        <?php if($old_value): ?>
            <?php
                if(!is_object($old_value)) {
                    $item = $connected_entity->find($old_value);
                }else{
                    $item = $old_value;
                }

            ?>
            <?php if($item): ?>
            
            <?php if($field['allows_null']): ?>)
            <option value="" selected>
                <?php echo e($field['placeholder']); ?>

            </option>
            <?php endif; ?>

            <option value="<?php echo e($item->getKey()); ?>" selected>
                <?php echo e($item->{$field['attribute']}); ?>

            </option>
            <?php endif; ?>
        <?php endif; ?>
    </select>

    
    <?php if(isset($field['hint'])): ?>
        <p class="help-block"><?php echo $field['hint']; ?></p>
    <?php endif; ?>
<?php echo $__env->make('crud::fields.inc.wrapper_end', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>





    
<?php $__env->startPush('crud_fields_styles'); ?>
    
    <?php Assets::echoCss('packages/select2/dist/css/select2.min.css'); ?>
    <?php Assets::echoCss('packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css'); ?>
    
    <?php if($field['allows_null']): ?>
        <?php if(! Assets::isLoaded('select2_from_ajax_custom_css')) { Assets::markAsLoaded('select2_from_ajax_custom_css');  ?>
        <style type="text/css">
            .select2-selection__clear::after {
                content: ' <?php echo e(trans('backpack::crud.clear')); ?>';
            }
        </style>
        <?php } ?>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

    
<?php $__env->startPush('crud_fields_scripts'); ?>
    
    <?php Assets::echoJs('packages/select2/dist/js/select2.full.min.js'); ?>
    <?php if(app()->getLocale() !== 'en'): ?>
        <?php Assets::echoJs('packages/select2/dist/js/i18n/' . str_replace('_', '-', app()->getLocale()) . '.js'); ?>
    <?php endif; ?>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('crud_fields_scripts'); ?>
<?php if(! Assets::isLoaded('bpFieldInitSelect2FromAjaxElement')) { Assets::markAsLoaded('bpFieldInitSelect2FromAjaxElement');  ?>
<script>
    function bpFieldInitSelect2FromAjaxElement(element) {
        var form = element.closest('form');
        var $placeholder = element.attr('data-placeholder');
        var $minimumInputLength = element.attr('data-minimum-input-length');
        var $dataSource = element.attr('data-data-source');
        var $method = element.attr('data-method');
        var $fieldAttribute = element.attr('data-field-attribute');
        var $connectedEntityKeyName = element.attr('data-connected-entity-key-name');
        var $includeAllFormFields = element.attr('data-include-all-form-fields')=='false' ? false : true;
        var $allowClear = element.attr('data-column-nullable') == 'true' ? true : false;
        var $dependencies = JSON.parse(element.attr('data-dependencies'));
        var $ajaxDelay = element.attr('data-ajax-delay');
        var $isFieldInline = element.data('field-is-inline');
        var $fieldCleanName = element.attr('data-repeatable-input-name') ?? element.attr('name');

        // do not initialise select2s that have already been initialised
        if ($(element).hasClass("select2-hidden-accessible"))
        {
            return;
        }
        //init the element
        $(element).select2({
            theme: 'bootstrap',
            multiple: false,
            placeholder: $placeholder,
            minimumInputLength: $minimumInputLength,
            allowClear: $allowClear,
            dropdownParent: $isFieldInline ? $('#inline-create-dialog .modal-content') : $(document.body),
            ajax: {
                url: $dataSource,
                type: $method,
                dataType: 'json',
                delay: $ajaxDelay,
                data: function (params) {
                    if ($includeAllFormFields) {
                        return {
                            q: params.term, // search term
                            page: params.page, // pagination
                            form: form.serializeArray(), // all other form inputs
                            triggeredBy: 
                            {
                                'rowNumber': element.attr('data-row-number') !== 'undefined' ? element.attr('data-row-number')-1 : false, 
                                'fieldName': $fieldCleanName
                            }
                        };
                    } else {
                        return {
                            q: params.term, // search term
                            page: params.page, // pagination
                        };
                    }
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    
                    //if we have data.data here it means we returned a paginated instance from controller.
                    //otherwise we returned one or more entries unpaginated.
                    let paginate = false;

                    if (data.data) {
                        paginate = data.next_page_url !== null;
                        data = data.data;
                    }

                    return {
                        results: $.map(data, function (item) {
                            var $itemText = processItemText(item, $fieldAttribute);
                            return {
                                text: $itemText,
                                id: item[$connectedEntityKeyName],
                            }
                        }),
                        pagination: {
                            more: paginate,
                        }
                    };
                },
                cache: true
            },
        });

        // if any dependencies have been declared
        // when one of those dependencies changes value
        // reset the select2 value
        for (var i=0; i < $dependencies.length; i++) {
            var $dependency = $dependencies[i];
            //if element does not have a custom-selector attribute we use the name attribute
            if(typeof element.attr('data-custom-selector') == 'undefined') {
                form.find('[name="'+$dependency+'"], [name="'+$dependency+'[]"]').change(function(el) {
                        $(element.find('option:not([value=""])')).remove();
                        element.val(null).trigger("change");
                });
            }else{
                // we get the row number and custom selector from where element is called
                let rowNumber = element.attr('data-row-number');
                let selector = element.attr('data-custom-selector');

                // replace in the custom selector string the corresponding row and dependency name to match
                selector = selector
                    .replaceAll('%DEPENDENCY%', $dependency)
                    .replaceAll('%ROW%', rowNumber);

                $(selector).change(function (el) {
                    $(element.find('option:not([value=""])')).remove();
                    element.val(null).trigger("change");
                });
            }
        }
    }

    if (typeof processItemText !== 'function') {
        function processItemText(item, $fieldAttribute) {
            var $appLang = '<?php echo e(app()->getLocale()); ?>';
            var $appLangFallback = '<?php echo e(Lang::getFallback()); ?>';
            var $emptyTranslation = '<?php echo e(trans("backpack::crud.empty_translations")); ?>';
            var $itemField = item[$fieldAttribute];

            // try to retreive the item in app language; then fallback language; then first entry; if nothing found empty translation string
            return typeof $itemField === 'object' && $itemField !== null
                ? $itemField[$appLang] ? $itemField[$appLang] : $itemField[$appLangFallback] ? $itemField[$appLangFallback] : Object.values($itemField)[0] ? Object.values($itemField)[0] : $emptyTranslation
                : $itemField;
        }
    }
    </script>
    <?php } ?>
<?php $__env->stopPush(); ?>


<?php /**PATH C:\Projects\needhelp\vendor\backpack\pro\src/../resources/views/fields/select2_from_ajax.blade.php ENDPATH**/ ?>