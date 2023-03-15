<input
    type="{{ $field->jiraSchema->type }}"
    id="{{ $field->fieldId }}"
    name="{{ $field->fieldId }}"
    {{$field->required ? 'required' : ''}}>
