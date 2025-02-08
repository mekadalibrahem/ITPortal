# V1

## Features

### Normal User 
* Home : page show current request (send and not ending yet) his sent and show notifications not read yet 
* Profile managment 
    - edit general information 
    - edit password 
    - logout from another devices ( show what devices used to login )
    - delete account 
* Request
    - add new request based for type of user 
    - edit request if still allowed to edit 
    - delete request if request (drafr , cheking ... status can user request delete for it) 
* Notifications
    - sent new notification to any user by his email ( email should registered in website database)
    - show notifications list 

### employee 
* all user features 
* request managment 
    - show what request send for him 
    - work in request ( redirect for another employee  or another department (when employee is department role))
    - cansel  ,accept , reject reqest  

### admin 
* all user features 
* collage managment 
    - add new collage information value (tested)
    - edit collage information value or name (tested)
    - show datatable of collage information data 
    - remove collage informations 

## Front-end

* add preline library.

## Back-end

* add migration , seeder , models and seeder data.
* add routes file.
* add Controllers , classes and Enums.
* add Language switcher for project.

## Dev

* add DebugBar Package

## required packages

### frontend

* preline
* edit profile page with its components

### backend

* jenssegers/agent
* liveware
* spatie/laravel-permission
<!-- 
* mpdf/mpdf
* spatie/browsershot
* spatie/laravel-backup
* spatie/laravel-pdf 
-->
* masmerise/livewire-toaster
* rappasoft/laravel-livewire-tables
