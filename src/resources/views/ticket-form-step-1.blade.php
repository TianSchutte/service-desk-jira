@extends('service-desk-jira::layouts.base')
@section('content')

    <form id="request-form">
        <label for="request_type">Select a request type:</label>
        <select id="request_type" name="request_type">
            <option value=""> -- Select a ticket --</option>

            @foreach ($requestTypes as $requestType)
                <option value="{{ $requestType->id }}">{{ $requestType->id }} - {{ $requestType->name }}</option>
            @endforeach
        </select>
    </form>

    <div id="request-form-results"></div>

    <script>
        $('#request_type').change(function () {
            var requestTypeId = $(this).val();
            $.ajax({
                type: 'POST',
                url: '{{ route('tickets.form.show') }}',
                //TODO: Change to using parameter in route
                data: {
                    _token: '{{ csrf_token() }}',
                    request_type_id: requestTypeId,
                },
                success: function (data) {
                    $('#request-form-results').html(data);
                },
            });
        });
    </script>
@endsection
