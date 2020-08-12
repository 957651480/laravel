/** When your routing table is too long, you can split it into small modules**/

import Layout from '@/layout'

const categoryRouter = {
    path: '/category',
    component: Layout,
    redirect: '/category/category',
    name: 'category',
    meta: {
        title: '栏目管理',
        icon: 'el-icon-folder'
    },
    children: [
        {
            path: 'category',
            component: () => import('@/views/category/List'),
            name: 'CategoryList',
            meta: { title: '栏目列表', icon: 'list',noCache: true }
        },
    ]
}

export default categoryRouter
