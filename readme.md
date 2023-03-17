
# Service-Desk-Jira

This package provides a button on websites where it is installed, which enables users to submit tickets to Jira Service Management site. Users can also view and comment on tickets related to their account.

## Features

- Submit tickets: Users can fill out a ticket form provided by the package and submit it to Jira Service Management site via API.
- View tickets: Users can view their created tickets through the package and stay up-to-date with any changes or updates made to them.
- Add comments: Users can add comments to their tickets directly through the package.


## Installation

### Service-Desk-Jira Setup
- Make an API key on Jira's site.
- Make a Service Management Project on Jira's site.


### Package Setup
- Add package to project 

```composer
composer require tianschutte/service-desk-jira
```

- In Project Driectory add the Service Provider Call in `/config/app.php`
```php
TianSchutte\ServiceDeskJira\Providers\ServiceDeskProvider.php::class,
```

- Run the following command to make alterations to config values as required

```php
php artisan vendor:publish --tag=config
```

- Run the following command to publish the css file for FE look and feel

```
php artisan vendor:publish --tag=public --force
```

- In the newly copied config file called servicedeskjira.php in `/config/servicedeskjira.php` make sure all details are set correctly
```php
    'base_url' => env('JIRA_SERVICE_DESK_BASE_URL', 'https://base.atlassian.net'),
    'email' => env('JIRA_SERVICE_DESK_EMAIL', 'base@email.guru'),
    'api_key' => env('JIRA_SERVICE_DESK_API_KEY','base'),
    'project_id' => env('JIRA_SERVICE_DESK_PROJECT_ID', '6'),
```
- After these steps, the button should appear on the site.

    
## Documentation

- [Jira: Service Desk Docs](https://docs.atlassian.com/jira-servicedesk/REST/3.6.2/#servicedeskapi)

# Appendix
- Make sure the user api being used has all required permissions to create and view tickets/users