# Todo Task Project

## About this project
This project is a simple task management system built using Laravel 11.

## Setup and run
1. Run `cp .env.example .env` to create a `.env` file.
2. Run `vendor/bin/sail up` to start the project. All necessary services will be started.
3. Run `vendor/bin/sail artisan migrate` to migrate the database.
4. Run `vendor/bin/sail artisan db:seed` to seed the database.

## How the project was implemented
1. All routes are defined in the `routes/api` folder, specifically in `auth.php`, `projects.php`, and `tasks.php` files.
2. Corresponding feature tests for all routes are in the `tests/Feature/api` folder. The `pest` package was used to implement the tests.
3. Authentication is handled by Laravel Sanctum.
4. Form requests and API resources are used to validate input and return output in a consistent format.
5. The logic is simple and implemented directly in the controllers. (In a real-world application, this could be improved by using services and repositories.)
6. An `OverDueTasks` command and `OverDueTaskNotification` notification were implemented to send notifications to task creators with overdue tasks.
7. Three indexes were added to the `tasks` table to optimize the search query in the `TaskController@index` method:
   - Two simple indexes on the `status` and `due_date` columns for filtering.
   - One composite index on the `title` and `description` columns for the search query.

## How to test
1. Run `vendor/bin/sail test` to execute the feature tests.
2. Use the Postman collection to test the endpoints. The collection is located at `public/Test.postman_collection.json`. All routes are protected by Sanctum. You can obtain a token from the `auth/login` endpoint (email: `john@doe.com`, password: `password`).
3. Run `vendor/bin/sail artisan over-due-tasks` to execute the `OverDueTasks` command. This command sends notifications to task creators with overdue tasks. You can view the emails in the MailHog dashboard (http://localhost:{FORWARD_MAILHOG_DASHBOARD_PORT}).