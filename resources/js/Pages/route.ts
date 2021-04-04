export default [
    {
        path: '/',
        name: 'welcome',
        children: [
            {
                path: '/test',
                name: 'test',
                children: [
                    {
                        path: '/test/antprotestone',
                        name: 'one',
                        exact: true,
                    },
                    {
                        path: '/test/antprotesttwo',
                        name: 'two',
                        exact: true,
                    },
                ],
            },
        ],
    },
    {
        path: '/file',
        name: '文件管理',
        children: [
            {
                path: 'file',
                name: '文件列表',
            },
            {
                path: 'folder',
                name: '文件夹列表',
            },
            {
                path: 'disk',
                name: '磁盘列表',
            },
        ],
    },
];
