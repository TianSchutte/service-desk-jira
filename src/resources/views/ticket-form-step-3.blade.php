@extends('service-desk-jira::layouts.base')
@section('content')
<h2>Request submitted successfully</h2>
<p>Issue key: {{$issueRequest->issueKey}}</p>
<p>Created date: {{$issueRequest->createdDate->friendly}}</p>
<p>Reporter name: {{$issueRequest->reporter->displayName}}</p>
<p>Reporter email: {{$issueRequest->reporter->emailAddress}}</p>
<p>Current status: {{$issueRequest->currentStatus->status}}</p>

@if($attachedFiles)
    @if(count($attachedFiles->attachments->values) > 0)
        <h3>Attached files:</h3>
        <ul>
            @foreach($attachedFiles->attachments->values as $attachment)
                <li>{{$attachment->filename}}</li>
                {{--             Uncomment the following lines if you want to display images--}}
                {{--            @if($attachment->mimeType == 'image/png')--}}
                {{--                <img src="{{$attachment->links->content}}" alt="{{$attachment->filename}}">--}}
                {{--            @endif--}}
            @endforeach
        </ul>
    @endif
@endif
@endsection
