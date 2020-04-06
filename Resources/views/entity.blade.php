<div class="{{ $classes->toHtml() }}">
    @foreach($fields as $field)
        {!! $field->render() !!}
    @endforeach
</div>