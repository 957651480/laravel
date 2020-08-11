import Layout from '@/layout'

const informationRouter= {
    path: '/information',
        component: Layout,
    redirect: '/information/list',
    name: 'Example',
    meta: {
    title: '新闻资讯管理',
        icon: 'el-icon-s-help'
    },
    children: [
        {
            path: 'create',
            component: () => import('@/views/information/create'),
            name: 'CreateInformation',
            meta: { title: '创建新闻资讯', icon: 'edit' }
        },
        {
            path: 'edit/:id(\\d+)',
            component: () => import('@/views/information/edit'),
            name: 'EditInformation',
            meta: { title: '编辑新闻资讯', noCache: true, activeMenu: '/information/list' },
            hidden: true
        },
        {
            path: 'list',
            component: () => import('@/views/information/list'),
            name: 'InformationList',
            meta: { title: '新闻资讯列表', icon: 'list' }
        }
    ]
}

export default informationRouter;
