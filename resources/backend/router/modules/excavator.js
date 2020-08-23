import Layout from '@/layout'

const excavatorRouter= {
    path: '/excavator',
    component: Layout,
    redirect: '/excavator/list',
    name: 'Excavator',
    meta: {
        title: '挖机管理',
        icon: 'el-icon-s-help'
    },
    children: [

        {
            path: 'create',
            component: () => import('@/views/excavator/create'),
            name: 'CreateExcavator',
            meta: { title: '创建挖机', icon: 'edit' }
        },
        {
            path: 'edit/:id(\\d+)',
            component: () => import('@/views/excavator/edit'),
            name: 'EditExcavator',
            meta: { title: '编辑挖机', noCache: true, activeMenu: '/excavator/list' },
            hidden: true
        },
        {
            path: 'list',
            component: () => import('@/views/excavator/list'),
            name: 'ExcavatorList',
            meta: { title: '挖机列表', icon: 'list' }
        },
        {
            path: 'brand/list',
            component: () => import('@/views/brand/List'),
            name: 'BrandList',
            meta: { title: '品牌列表', icon: 'list',noCache: true },
        },
    ]
}

export default excavatorRouter;
