@extends('service-desk-jira::layouts.base')
@section('content')
<h2>Ticket submitted successfully</h2>
<table>
    <tr>
        <th>Issue Id</th>
        <td>{{$issueRequest->issueId}}</td>
    </tr>
    <tr>
        <th>Issue Key</th>
        <td>{{$issueRequest->issueKey}}</td>
    </tr>
    <tr>
        <th>Created Date</th>
        <td>{{$issueRequest->createdDate->friendly}}</td>
    </tr>
    <tr>
        <th>Reporter Name</th>
        <td>{{$issueRequest->reporter->displayName}}</td>
    </tr>
    <tr>
        <th>Reporter Email</th>
        <td>{{$issueRequest->reporter->emailAddress}}</td>
    </tr>
    <tr>
        <th>Current Status</th>
        <td>{{$issueRequest->currentStatus->status}}</td>
    </tr>
</table>


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
