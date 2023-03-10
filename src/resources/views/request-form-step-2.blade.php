@if ($fields)
    <form method="post" action="{{ route('form-step-submit') }}" enctype="multipart/form-data">
        @csrf
        @foreach ($fields as $field)
            <div>
                <label for="{{ $field->fieldId }}">{{ $field->name }}</label>
                @switch($field->jiraSchema->type)
                    @case('datetime')
                        <input type="datetime-local" id="{{ $field->fieldId }}" name="{{ $field->fieldId }}">
                        @break
                    @case('textarea')
                        <textarea id="{{ $field->fieldId }}" name="{{ $field->fieldId }}"></textarea>
                        @break
                    @case('array')
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
                        @break
                    @case('option')
                        <select id="{{ $field->fieldId }}" name="{{ $field->fieldId }}[id]">
                            @foreach ($field->validValues as $option)
                                <option value="{{ $option->value }}">{{ $option->label }}</option>
                            @endforeach
                        </select>
                        @break
                    @default
                        <input type="{{ $field->jiraSchema->type }}" id="{{ $field->fieldId }}" name="{{ $field->fieldId }}">
                @endswitch
            </div>
        @endforeach
        <input type="hidden" name="request_type_id" value="{{ $requestTypeId }}">
        <button type="submit">Submit</button>
    </form>
@endif
