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
                            'route' => 'admin.auth.role',
                        ],
                        'user' => [
                            'name' => 'string.Users',
                            'route' => 'admin.auth.user',
                        ],
                        'permission' => [
                            'name' => 'string.Permissions',
                            'route' => 'admin.auth.permission',
                        ],
                    ],
                ],
                'requests' => [
                    'name' => 'string.Requests',
                    'route' => null,
                    "children" => [
                        'type' => [
                            'name' => 'string.Request type',
                            'route' => 'admin.requests.type',
                        ],
                        'requests' => [
                            'name' => 'string.Requests',
                            'route' => 'admin.requests.requset',
                        ],
                    ],
                ],
                'employees' => [
                    'name' => 'string.Employees',
                    'route' => null,
                    "children" => [
                        'employee' => [
                            'name' => 'string.Employee',
                            'route' => 'admin.employee.employee',
                        ],
                        'department' => [
                            'name' => 'string.Department',
                            'route' => 'admin.employee.department',
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
        'admin.auth.permission' => 'dashboard.auth.permission',
        'admin.auth.role' => 'dashboard.auth.role',
        'admin.auth.user' => 'dashboard.auth.user',
        'admin.collage.index' => 'dashboard.collage',
        'admin.collage.create' => 'dashboard.collage',
        'admin.collage.edit' => 'dashboard.collage',
        'admin.employee.department' => 'dashboard.employees.department',
        'admin.employee.employee' => 'dashboard.employees.employee',
        'admin.requests.requset' => 'dashboard.requests.requset',
        'admin.requests.type' => 'dashboard.requests.type',
        'admin.staticties' => 'dashboard.staticties',
        'employee.requests' => 'dashboard.requests',
        'employee.edit.requests' => 'dashboard.requests',

    ]
];
