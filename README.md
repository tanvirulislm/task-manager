# Task Management with Filament

This project demonstrates how to manage tasks effectively using Filament, a powerful Laravel package for building admin panels. It includes features such as marking tasks as completed, filtering tasks based on their status, and displaying tasks in an organized and user-friendly table.

## Features

-   **Display tasks with different statuses**: View tasks categorized as Pending, In Progress, or Completed.
-   **Mark tasks as completed**: Easily update the status of tasks to completed.
-   **View completed tasks**: A dedicated resource to display only completed tasks.
-   **Dynamic filtering**: Filter tasks based on their status (Pending, In Progress, Completed).
-   **Display badges for task statuses**: Visual indicators for task statuses using badges.
-   **Customizable table views**: Organize and display tasks in a user-friendly table format.

## Usage

Anyone can take this code. No need for permission. Everyone is welcome to provide feedback and point out any mistakes.

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/tanvirulislm/task-manager.git
    ```
2. Navigate to the project directory:
    ```bash
    cd task-manager
    ```
3. Install the dependencies:
    ```bash
    composer install
    npm install
    ```
4. Set up the environment file:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
5. Run the migrations:
    ```bash
    php artisan migrate
    ```

## Contributing

Feel free to open issues or submit pull requests if you find any bugs or have suggestions for improvements.

## License

This project is open-source and available under the [MIT License](LICENSE).
