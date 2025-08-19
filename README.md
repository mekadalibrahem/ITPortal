# ITE College Request Management System

System for managing requests from students and employees at ITE College, Homs University.

## Features

### Normal User

- **Home**: Displays active requests and unread notifications.
- **Profile Management**:
  - Edit general information (**tested**).
  - Change password (**tested**).
  - Update signature.
  - Logout from other devices (view logged-in devices).
  - Delete account.
- **Request**:
  - Create new request based on user type.
  - Edit request if editable.
  - Delete request (draft/checking status only).
- **Notifications**:
  - Send notifications to users via registered email.
  - View notifications list.

### Employee

- All normal user features.
- **Request Management**:
  - View requests with actionable steps (department managers see department-specific requests).
  - Actions: Request edits, accept/reject (with notifications), export to PDF.

### Admin

- All normal user features.
- **College Management**:
  - Add new college info (**tested**).
  - Edit college info/name (**tested**).
  - View college info datatable.
  - Remove college info.
- **Request Management**:
  - Edit requests (**tested**).
  - View requests info table.
  - Delete requests.
- **Request Types Management** (**tested**):
  - View request types table with delete/edit/create options.
  - Edit/create request types.
- **Request Template**:
  - Manage request steps (CRUD).
  - Manage request templates (CRUD).
  - Manage print templates (using `msa/laravel-grapes`).
- **Employees**:
  - **Department Management** (**tested**):
    - View departments with delete/edit/create options.
    - Create/edit departments.
    - Add/remove employees from departments.
  - **Employee Management** (**tested**):
    - View employees with delete/add/edit options.
    - Create/edit employees, assign employee role, edit department.
    - Delete employee (some configuration issues).
- **Auth Management**:
  - **Roles Management** (**tested**):
    - View roles table with delete/add/edit options.
    - Create/edit/delete roles, manage permissions.
  - **Permission Management**:
    - View permissions table with delete/add/edit options.
    - Create/edit/delete permissions.
  - **User Authorization Management**:
    - View user roles/permissions.
    - Search users by email.
    - Assign/revoke roles/permissions.

## Front-end

- Uses Preline library.

## Back-end

- Includes migrations, seeders, models, and seeder data.
- Routes file included.
- Controllers, classes, and enums implemented.
- Language switcher support.

## Development Tools

- DebugBar package.

- Telescope package.
