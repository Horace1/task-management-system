# Task Management System

Welcome to my Task Management System, a Laravel-based web application built to help teams organise projects, assign work, and monitor progress from one central dashboard. The system includes dedicated experiences for admins, project managers, and employees so each user only sees the tools and data relevant to their role.

## Key Features

- Role-Based Access Control: Supports Admin, Project Manager, and Employee roles using Bouncer permissions.
- Project Management: Create, edit, view, and delete projects with assigned managers, deadlines, descriptions, and status tracking.
- Task Management: Create tasks, attach them to projects, assign multiple employees, and manage task deadlines and statuses.
- Employee Workspace: Employees can view only their assigned projects and tasks, along with upcoming deadlines and recent activity.
- Dashboard Reporting: Admins and project managers can see project counts, task totals, team distribution, and recent project activity.
- User Management: Manage team members, assign roles, and upload profile photos from the admin area.
- Seeded Demo Data: Includes sample users, projects, tasks, roles, and statuses for quick local testing.

## Technologies Utilized

- Backend: PHP 8.2, Laravel 12, Livewire 3, Laravel Jetstream, Laravel Sanctum, and Bouncer.
- Frontend: Blade, Tailwind CSS, Vite, JavaScript, jQuery, and Select2.

## Status Workflow

- Project Statuses: Not Started, Pending, In Progress, Completed.
- Task Statuses: Not Started, Pending, In Progress, Done.

## Getting Started

1. Clone the repository.
2. Install PHP dependencies with `composer install`.
3. Install frontend dependencies with `npm install`.
4. Create your environment file with `copy .env.example .env`.
5. Generate the application key with `php artisan key:generate`.
6. Update your database settings inside `.env`.
7. Run migrations and seeders with `php artisan migrate --seed`.
8. Create the storage symlink with `php artisan storage:link`.
9. Start the frontend build with `npm run dev`.
10. Start the Laravel server with `php artisan serve`.

## Demo Accounts

- Admin: `admin@admin.com` / `admin123`
- Project Manager: `johndoe@googlemail.com` / `JohnDoe1`
- Employee: `janedoe@googlemail.com` / `JaneDoe1`
