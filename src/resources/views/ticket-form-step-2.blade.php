@if ($fields)
    <form method="post" action="{{ route('tickets.form.store') }}" enctype="multipart/form-data">
        @csrf
        <table>
            @foreach ($fields as $field)
                <tr>
                    <td><label for="{{ $field->fieldId }}">{{ $field->name }}</label></td>
                    <td>
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
                    </td>
                </tr>
            @endforeach
        </table>
        <input type="hidden" name="request_type_id" value="{{ $requestTypeId }}">
        <button type="submit">Submit</button>
    </form>
@endif
