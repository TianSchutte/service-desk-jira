<h2>{{$issue->issueKey}}</h2>

@if ($issue->requestFieldValues)
    <table>
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
