<!-- resources/views/request-form-part-1.blade.php -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<form id="request-form">
    <label for="request_type">Select a request type:</label>
    <select id="request_type" name="request_type">
        @foreach ($requestTypes as $requestType)
            <option value="{{ $requestType->id }}">{{ $requestType->id }} - {{ $requestType->name }}</option>
        @endforeach
    </select>
</form>

<div id="request-form-results"></div>

<script>
    $('#request_type').change(function() {
        var requestTypeId = $(this).val();
        $.ajax({
            type: 'POST',
            url: '{{ route('form-step-2') }}',
            data: {
                _token: '{{ csrf_token() }}',
                request_type_id: requestTypeId,
            },
            success: function(data) {
                $('#request-form-results').html(data);
            },
        });
    });
</script>
