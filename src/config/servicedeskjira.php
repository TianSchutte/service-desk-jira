<?php

return [
    'base_url' => env('JIRA_SERVICE_DESK_BASE_URL', 'https://base.atlassian.net'),
    'email' => env('JIRA_SERVICE_DESK_EMAIL', 'base@email.com'),
    'api_key' => env('JIRA_SERVICE_DESK_API_KEY', 'base'),
    'project_id' => env('JIRA_SERVICE_DESK_PROJECT_ID', '6'),
    'field_ids' => [
            'service_field_id' => env('JIRA_SERVICE_DESK_SERVICE_FIELD_ID', 'customfield_10051'),
            'user_field_id' => env('JIRA_SERVICE_DESK_USER_FIELD_ID', 'customfield_10003'),
        ],
    'default_assignee' => env('JIRA_SERVICE_DESK_DEFAULT_ASSIGNEE', 'example@email.com'),

];
