### Example config

file path : /config/stubGenerator.php

```
return [
  'directories'     => [
    'Module'  => [
      'targets' => [
        ['namespace' => 'Modules', 'path' => base_path('modules').'/'],
        ['namespace' => 'Packages', 'path' => base_path('packages').'/'],
        ['namespace' => 'Projects', 'path' => base_path('projects').'/'],
      ],
    ],
    'Project' => [
      'targets' => [['namespace' => 'Projects', 'path' => base_path('projects').'/'],],
    ],
    'Package' => [
      'targets' => [['namespace' => 'Packages', 'path' => base_path('packages').'/'],],
    ],
  ],
  'fileTypeRewrite' => [
    '.php',
    '.stub',
    '.json',
  ],
  'fileTypeRemove'  => [
    '.stub',
  ],
];
```

stub directories in base_path/stubs like:

```
base_path/stubs
    modules
        directory/
        file.stub
        file.php.stub
    projects
        directory/
        file.stub
        file.php.stub
    packages
        directory/
        file.stub
        file.php.stub
```