import Layout from '@/layout'

const excavatorRouter= {
    path: '/excavator',
    component: Layout,
    redirect: '/excavator/brand',
    name: 'Example',
    meta: {
        title: '挖机管理',
        icon: 'el-icon-s-help'
    },
    children: [

        {
            path: 'brand/list',
            component: () => import('@/views/brand/List'),
            name: 'BrandList',
            meta: { title: '品牌列表', icon: 'list',noCache: true },
        },
    ]
}

export default excavatorRouter;
