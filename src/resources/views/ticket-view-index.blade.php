@extends('service-desk-jira::layouts.base')
@section('content')

    <form id="view-form">
        <label for="select-ticket">Select a ticket:</label>
        <select id="select-ticket" name="select-ticket">
            <option value=""> -- Select a ticket --</option>
            @foreach($tickets->values as $ticket)
                <option value="{{$ticket->issueId}}">{{ $ticket->requestTypeId}} - {{ $ticket->issueKey }}
                    created {{$ticket->createdDate->friendly}}</option>
            @endforeach
        </select>
    </form>

    <div id="select-ticket-results"></div>

    <script>
        $('#select-ticket').change(function () {
            var requestedTicketId = $(this).val();
            $.ajax({
                type: 'GET',
                url: '{{ route('tickets.view.show') }}',
                // url: '/tickets/' + requestedTicketId,
                //TODO: Change to using parameter in route

                data: {
                    _token: '{{ csrf_token() }}',
                    request_ticket_id: requestedTicketId,
                },
                success: function (data) {
                    $('#select-ticket-results').html(data);
                },
            });
        });
    </script>
@endsection