@if(count($comments) > 0)
    <h2>Comments:</h2>
    @foreach($comments as $comment)
        <div class="comment-container">
            <div class="comment-header">
                <span class="comment-author">{{ $comment->author->displayName }}</span>
                <span class="comment-timestamp">{{ $comment->created->friendly }}</span>
            </div>
            <div class="comment-body">
                <p>{{ $comment->body }}</p>
            </div>
        </div>

        @if(isset($comment->attachments))
            @foreach($comment->attachments as $attachment)
                <a href="{{ $attachment->content }}">{{ $attachment->filename }}</a>
            @endforeach
        @endif

    @endforeach

@endif
<br>
<form method="post" id="comment_form" action="{{ route('tickets.view.comments.store') }}">
    @csrf
    <input type="hidden" name="issue_key" value="{{$issue->issueKey}}" required>
    <label for="comment_body">Add a Comment:</label>
    <textarea name="comment_body" id="comment_body" cols="30" rows="5" required></textarea>
    <button id="comment_submit" type="submit">Add comment</button>
</form>
<script>
    $('#comment_form').on('submit', function () {
        $('#comment_submit').prop('disabled', true);
    });
</script>
