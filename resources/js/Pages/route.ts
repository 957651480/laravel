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
        path: '/demo',
        name: 'demo',
    },
];
