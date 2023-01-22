{{-- views field --}}
@includeWhen(!isset($field['wrapper']) || $field['wrapper'] !== false, 'crud::fields.inc.wrapper_start')
  @include($field['views'], ['crud' => $crud, 'entry' => $entry ?? null, 'field' => $field])
@includeWhen(!isset($field['wrapper']) || $field['wrapper'] !== false, 'crud::fields.inc.wrapper_end')
