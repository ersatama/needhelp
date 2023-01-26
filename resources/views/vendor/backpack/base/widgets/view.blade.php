{{-- views field --}}
@includeWhen(!empty($widget['wrapper']), 'backpack::widgets.inc.wrapper_start')

	@include($widget['views'], ['widget' => $widget])

@includeWhen(!empty($widget['wrapper']), 'backpack::widgets.inc.wrapper_end')
