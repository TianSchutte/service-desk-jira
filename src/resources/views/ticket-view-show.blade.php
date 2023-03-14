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

<h2>Add a comment</h2>
<form method="post" id="comment_form" action="{{ route('tickets.comments.store') }}">
    @csrf
    <input type="hidden" name="issue_key" value="{{$issue->issueKey}}">
    <label for="comment_body">Comment body:</label>
    <textarea name="comment_body" id="comment_body" cols="30" rows="5"></textarea>
    <button id="comment_submit" type="submit">Add comment</button>
</form>

