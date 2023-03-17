@extends('service-desk-jira::layouts.base')
@section('content')
<h2>Ticket submitted successfully</h2>
<table>
    <tr>
        <th>Link</th>
        <td><a href="{{$issueRequest->_links->web}}">Jira Service Desk</a></td>
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
    <tr>
        <th>Issue Key</th>
        <td>{{$issueRequest->issueKey}}</td>
    </tr>
    <tr>
        <th>Created Date</th>
        <td>{{$issueRequest->createdDate->friendly}}</td>
    </tr>
</table>


@if($attachedFiles)
    @if(count($attachedFiles->attachments->values) > 0)
        <h3>Attached files:</h3>
        <ul>
            @foreach($attachedFiles->attachments->values as $attachment)
                <li><a href="{{$attachment->_links->content}}" target="_blank" >{{$attachment->filename}}</a></li>
            @endforeach
        </ul>
    @endif
@endif
@endsection
