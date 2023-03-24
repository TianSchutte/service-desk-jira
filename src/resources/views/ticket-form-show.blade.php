@extends('service-desk-jira::layouts.base')
@section('content')

    @if ($fields)
        <form method="post"
              action="{{ route('tickets.form.store') }}"
              id="ticket-form-store"
              enctype="multipart/form-data">
            @csrf

            <table>
                <caption><h2>{{$requestType->name}}</h2></caption>
                <caption><p>{{$requestType->description}}</p></caption>
                @foreach ($fields as $field)
                    <tr>
                        <td><label for="{{ $field->fieldId }}">{{ $field->name }}</label></td>
                        <td>
                            @switch($field->jiraSchema->type)
                                @case('datetime')
                                    @include('service-desk-jira::partials.ticket-form.datetime', ['field' => $field])
                                    @break
                                @case('date')
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
            @include('service-desk-jira::partials.error-message')
            <button type="submit" id="submit">Submit</button>
        </form>
    @endif

    <script>
        $('#ticket-form-store').on('submit', function () {
            $('#submit').prop('disabled', true);
        });
    </script>

@endsection