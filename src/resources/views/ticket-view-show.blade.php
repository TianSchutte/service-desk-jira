@if ($issue->requestFieldValues)
    <table>

        <tr>
            <th>Link</th>
            <td><a href="{{$issue->_links->web}}"> {{$issue->_links->web}}</a></td>
        </tr>
{{--        <tr>--}}
{{--            <th>Issue Key</th>--}}
{{--            <td>{{$issue->issueKey}}</td>--}}
{{--        </tr>--}}
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
