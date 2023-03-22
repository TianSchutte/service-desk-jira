<input
    type="{{ $field->jiraSchema->type }}"
    id="{{ $field->fieldId }}"
    name="{{ $field->fieldId }}"
    value="{{old($field->fieldId)}}"
    {{$field->required ? 'required' : ''}}>
