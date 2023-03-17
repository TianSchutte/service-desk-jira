@extends('service-desk-jira::layouts.base')
@section('content')

    <form id="request-form">
        <label for="request_type">Select a request type:</label>
        <select id="request_type" name="request_type">
            <option value=""> -- Select a ticket --</option>

            @foreach ($requestTypes as $requestType)
                <option value="{{ $requestType->id }}">{{ $requestType->name }}</option>
            @endforeach
        </select>
    </form>

    @include('service-desk-jira::partials.error-message')

    <div id="request-form-results"></div>

    <script>
        $('#request_type').change(function () {
            var requestTypeId = $(this).val();
            $.ajax({
                type: 'GET',
                url: '{{ route('tickets.form.show', ['id' => ':id']) }}'.replace(':id', requestTypeId),
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    $('#request-form-results').html(data);
                },
            });
        });
    </script>
@endsection
