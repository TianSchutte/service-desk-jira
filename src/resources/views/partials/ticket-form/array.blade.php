@if ($field->jiraSchema->items == 'attachment')
    <input type="file" id="{{ $field->fieldId }}" name="{{ $field->fieldId }}[]" multiple>
@elseif ($field->jiraSchema->items == 'service-entity-field')
    <select id="{{ $field->fieldId }}" name="{{ $field->fieldId }}[][value]" multiple>
        @foreach ($services->services as $option)
            <option value="{{ $option->id }}">{{ $option->name }}</option>
        @endforeach
    </select>
@elseif ($field->jiraSchema->items == 'component')
    <select id="{{ $field->fieldId }}" name="{{ $field->fieldId }}[][id]" multiple>
        @foreach ($field->validValues as $option)
            <option value="{{ $option->value }}">{{ $option->label }}</option>
        @endforeach
    </select>
@elseif ($field->jiraSchema->items == 'user')
    <select id="{{ $field->fieldId }}" name="{{ $field->fieldId }}[][value]" multiple>
        @foreach ($users as $option)
            <option value="{{ $option->accountId }}">{{ $option->displayName }}</option>
        @endforeach
    </select>
@endif
