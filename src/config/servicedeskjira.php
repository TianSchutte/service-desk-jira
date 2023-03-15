<?php

return [
    'base_url' => env('JIRA_SERVICE_DESK_BASE_URL', 'https://base.atlassian.net'),
    'email' => env('JIRA_SERVICE_DESK_EMAIL', 'base@email.guru'),
    'api_key' => env('JIRA_SERVICE_DESK_API_KEY','base'),
    'project_id' => env('JIRA_SERVICE_DESK_PROJECT_ID', '3'),
];
