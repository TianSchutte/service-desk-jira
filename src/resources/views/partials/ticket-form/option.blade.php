<select id="{{ $field->fieldId }}" name="{{ $field->fieldId }}[id]">
    @foreach ($field->validValues as $option)
        <option value="{{ $option->value }}">{{ $option->label }}</option>
    @endforeach
</select>
