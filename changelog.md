# V1

## Features

### Normal User

* Home : page show current request (send and not ending yet) his sent and show notifications not read yet
* Profile managment
  * edit general information  **`tested`**
  * edit password  **`tested`**
  * edit signature
  * logout from another devices ( show what devices used to login )
  * delete account
* Request
  * add new request based for type of user
  * edit request if still allowed to edit
  * delete request if request (drafr , cheking ... status can user request delete for it)
* Notifications
  * sent new notification to any user by his email ( email should registered in website database)
  * show notifications list

### employee

* all user features
* request managment
  * show what request  sendt (that have at less one step can work on it) ->(department manager show all requests that have step for his department)
  * work in request
    * ask user to edit  (with sent notification to user)
    * accept , reject  (with notification to user )
    * export to file (pdf)

### admin

* all user features
* collage managment
  * add new collage information value   **`tested`**
  * edit collage information value or name   **`tested`**
  * show datatable of collage information data
  * remove collage informations
* request managment
  * edit request   **`tested`**
  * show requests information table
  * delete request
* request types managment    **`tested`**
  * show request types table with delete options ( redirect to edit or create new pages)
  * edit type
  * create new type
* request Template
  * request steps managment (CRUD)
  * request template managment (CRUD)
  * request print template managment  (package : msa/laravel-grapes)
* employess

  * departmetn managment    **`tested`**
    * show departmetns informations with options (delete and redirect for edit or create new)
    * create new Department  
    * edit Department
    * add employee for department or remove them

  * Employee Managment   **`tested`**
    * show employees with option for (delete , add new and edit)
    * create new Employee and assign Role(employee ) for him
    * edit employee ( edit department )
    * delete employee need to some configurtion so now not work correct all time
* Auth Managment
  * Roles Managment  **`tested`**
    * show Roles Table with option for (delete , add new and edit)
    * create new Role
    * edit role and what permission have
    * delete role
  * Permission Managment
    * show Permission Table with option for (delete , add new and edit)
    * create new Permission
    * edit Permission
    * delete Permission
  * User Authorization Managment
    * show user roles and permissions
    * search by user email
    * assign permission or role to user
    * revoke permission or role from user
* backups
  * backups for database and all images (files ) uploaded
  * action : run backup ,show , download   and  delete
  
## Front-end

* add preline library.

## Back-end

* add migration , seeder , models and seeder data.
* add routes file.
* add Controllers , classes and Enums.
* add Language switcher for project.

## Dev

* add DebugBar Package
* add Telescope package

## required packages

### frontend

* preline

### backend

* jenssegers/agent
* liveware/liveware
* spatie/laravel-permission
* spatie/browsershot
* msa/laravel-grapes
* masmerise/livewire-toaster
* rappasoft/laravel-livewire-tables
* spatie/laravel-backup
