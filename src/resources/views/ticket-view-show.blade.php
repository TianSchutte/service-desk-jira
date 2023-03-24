@if($issue->currentStatus)
    <div class="status-container">
       <p>
           Ticket <strong>{{$issue->issueKey}}</strong>
           is in category <strong>{{ $issue->currentStatus->statusCategory }}</strong>
           with status of <strong>{{ $issue->currentStatus->status }} </strong>
           since <strong>{{ $issue->currentStatus->statusDate->friendly }}</strong>
       </p>
    </div>
@endif

@if ($issue->requestFieldValues)
    <table>
        <tr>
            <th>Link</th>
            <td><a href="{{$issue->_links->web}}">Jira Service Desk</a></td>
        </tr>
        @foreach ($issue->requestFieldValues as $item)
            <tr>
                <th>{{ $item->label }}</th>
                <td>
                    @if ($item->fieldId === 'attachment')
                        @foreach ($item->value as $attachment)
                            <a href="{{ $attachment->content }}" target="_blank">{{ $attachment->filename }}</a>
                        @endforeach
                    @elseif (isset($item->value->value))
                        {{ $item->value->value }}
                    @elseif (isset($item->value))
                        {{ $item->value }}
                    @else
                        N/A
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
@endif

@include('service-desk-jira::ticket-view-show-comment')
