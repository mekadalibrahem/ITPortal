<?php
return  [
    'admin' => [
        'dashboard' => [
            "name" => 'string.Dashboard',
            'route' => 'dashboard.index',
            'children' => [
                'staticties' => [
                    'name' => 'string.Staticties',
                    'route' => 'admin.staticties',
                ],
                'auth' => [
                    'name' => 'string.Authorization',
                    'route' => null,
                    "children" => [
                        'role' => [
                            'name' => 'string.Roles',
                            'route' => 'admin.auth.role.index',
                        ],
                        'user' => [
                            'name' => 'string.Users',
                            'route' => 'admin.auth.user.index',
                        ],
                        'permission' => [
                            'name' => 'string.Permissions',
                            'route' => 'admin.auth.permission.index',
                        ],
                    ],
                ],
                'requests' => [
                    'name' => 'string.Requests',
                    'route' => null,
                    "children" => [
                        'type' => [
                            'name' => 'string.Request type',
                            'route' => 'admin.requests.type.index',
                        ],
                        'request' => [
                            'name' => 'string.Request details',
                            'route' => 'admin.requests.request.index',
                        ],
                    ],
                ],
                'employees' => [
                    'name' => 'string.Employees',
                    'route' => null,
                    "children" => [
                        'employee' => [
                            'name' => 'string.employee',
                            'route' =>  'admin.employee.index',
                        ],
                        'department' => [
                            'name' => 'string.Department',
                            'route' => 'admin.department.index',
                        ],
                    ],
                ],
                'backup' => [
                    'name' => 'string.Backups',
                    'route' => 'admin.backups',
                ],
                'collage' => [
                    'name' => 'string.Collage informations',
                    'route' => 'admin.collage.index',
                ],
            ],
        ],
    ],
    'employee' => [
        'dashboard' => [
            'requests' => [
                'name' => 'string.Employee Requests',
                'route' => 'employee.requests',
            ],
        ],
    ],

    'paths' => [
        'admin.auth.permission.index' => 'dashboard.auth.permission',
        'admin.auth.permission.create' => 'dashboard.auth.permission',
        'admin.auth.permission.edit' => 'dashboard.auth.permission',

        'admin.auth.role.index' => 'dashboard.auth.role',
        'admin.auth.role.edit' => 'dashboard.auth.role',
        'admin.auth.role.create' => 'dashboard.auth.role',

        'admin.auth.user.index' => 'dashboard.auth.user',
        // 'admin.auth.user.create' => 'dashboard.auth.user',
        // 'admin.auth.user.edit' => 'dashboard.auth.user',

        'admin.collage.index' => 'dashboard.collage',
        'admin.collage.create' => 'dashboard.collage',
        'admin.collage.edit' => 'dashboard.collage',

        'admin.requests.request.index' => 'dashboard.requests.request',
        'admin.requests.request.edit' => 'dashboard.requests.request',
        'admin.requests.request.create' => 'dashboard.requests.request',

        'admin.requests.type.index' => 'dashboard.requests.type',
        'admin.requests.type.create' => 'dashboard.requests.type',
        'admin.requests.type.edit' => 'dashboard.requests.type',

        'admin.department.index' => 'dashboard.employees.department',
        'admin.department.create' => 'dashboard.employees.department',
        'admin.department.edit' => 'dashboard.employees.department',

        'admin.employee.index' => 'dashboard.employees.employee',
        'admin.employee.create' => 'dashboard.employees.employee',
        'admin.employee.edit' => 'dashboard.employees.employee',
        'admin.staticties' => 'dashboard.staticties',
        'employee.requests' => 'dashboard.requests',
        'employee.edit.requests' => 'dashboard.requests',

    ]
];
