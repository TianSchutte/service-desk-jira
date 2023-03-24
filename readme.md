
# Service-Desk-Jira

This package provides a button on websites where it is installed, which enables users to submit tickets to Jira Service Management site. Users can also view and comment on tickets related to their account.

## Features
### Main
- Floating Button: Button is added to the site, which when clicked, opens a modal with the ticket form, in an IFrame.
  - This button is also only available to authenticated users, who are added as customers on jira's side.
- Submit tickets: Users can fill out a ticket form provided by the package and submit it to Jira Service Management site via API.
  - Process is similar to submitting a ticket on Jira Service Management site, but with a few differences.
    - Process is: Choose Create, Choose Group, Choose Type, Fill out form, Submit. Easy.
    - Users can only submit tickets to a given project.
  - Ticket form fields & Groups are dynamic, meaning you can create it on Jira side and should automatically appear with given fields.
  - Ticket form fields are also validated on the front-end and back-end.
  - Attachments, can be added to the ticket form.
- View tickets: Users can view their created tickets through the package and stay up-to-date with any changes or updates made to them.
- Add comments: Users can add comments to their tickets directly through the package.
### Secondary
- Basic authentication: Users can only use the package functionality if they are logged in.
- View Package Info: Users can view the package info and version number, etc.
- View User Tickets: Users can view all tickets related to given email.

## Installation

### Service-Desk-Jira Setup
- Make an Jira Service Desk Account, specifically for this package (not required)
- Generate an API key on Jira's site, for account.
- Supply the correct permissions to this account.
- Make a Service Management Project on Jira's site. (if you don't have one already)
- Fill in the required information in the .env file or in the config file.
```dotenv
JIRA_SERVICE_DESK_BASE_URL='https://base.atlassian.net'
JIRA_SERVICE_DESK_EMAIL='example@email.com'
JIRA_SERVICE_DESK_API_KEY='---'
JIRA_SERVICE_DESK_PROJECT_ID=6
JIRA_SERVICE_DESK_DEFAULT_ASSIGNEE='example@email.com'
```


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

```bash
php artisan vendor:publish --tag=config
```

- Run the following command to publish the css file for FE look and feel

```bash
php artisan vendor:publish --tag=public --force
```

- In the newly copied config file called servicedeskjira.php in `/config/servicedeskjira.php` make sure all details are set correctly
```dotenv
    'base_url' => env('JIRA_SERVICE_DESK_BASE_URL', 'https://base.atlassian.net'),
    'email' => env('JIRA_SERVICE_DESK_EMAIL', 'base@email.com'),
    'api_key' => env('JIRA_SERVICE_DESK_API_KEY', 'base'),
    'project_id' => env('JIRA_SERVICE_DESK_PROJECT_ID', '6'),
    'field_ids' => [
        'service_field_id' => env('JIRA_SERVICE_DESK_SERVICE_FIELD_ID', 'customfield_10051'),
        'user_field_id' => env('JIRA_SERVICE_DESK_USER_FIELD_ID', 'customfield_10003'),
    ],
    'default_assignee' => env('JIRA_SERVICE_DESK_DEFAULT_ASSIGNEE', 'example@email.com'),
    'api_prefix' => [
        'rest_customer_portal' => 'rest/servicedesk/1/customer/portal',
        'rest_service_desk_api' => 'rest/servicedeskapi',
        'rest_service_desk_api_service_desk' => 'rest/servicedeskapi/servicedesk',
        'rest_api' => 'rest/api',
        'rest_service_registry'=>'rest/service-registry-api'
    ]
```
- Test the connection by running the following command in the project directory
```bash
php artisan service-desk:info
```
- After these steps, the button should appear on the site, and once your account is authenticated, it should be usable.

    
## Documentation
- [Jira: Service Desk Docs](https://docs.atlassian.com/jira-servicedesk/REST/3.6.2/#servicedeskapi)

# Appendix
- Make sure the user api being used has all required permissions to create and view tickets/users