@if ($fields)
    <form method="post" action="{{ route('form-step-submit') }}" enctype="multipart/form-data">
        @csrf
        @foreach ($fields as $field)
            <div>
                <label for="{{ $field->fieldId }}">{{ $field->name }}</label>
                @switch($field->jiraSchema->type)
                    @case('datetime')
                        @include('service-desk-jira::partials.ticket-form.datetime', ['field' => $field])
                        @break
                    @case('textarea')
                        @include('service-desk-jira::partials.ticket-form.textarea', ['field' => $field])
                        @break
                    @case('array')
                        @include('service-desk-jira::partials.ticket-form.array', ['field' => $field])
                        @break
                    @case('option')
                        @include('service-desk-jira::partials.ticket-form.option', ['field' => $field])
                        @break
                    @default
                        @include('service-desk-jira::partials.ticket-form.default', ['field' => $field])
                @endswitch
            </div>
        @endforeach
        <input type="hidden" name="request_type_id" value="{{ $requestTypeId }}">
        <button type="submit">Submit</button>
    </form>
@endif
