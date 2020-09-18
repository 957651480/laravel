/** When your routing table is too long, you can split it into small modules**/

import Layout from '@/layout'

const reserveRouter = {
    path: '/reserve',
    component: Layout,
    redirect: '/reserve/reserve',
    name: 'reserve',
    meta: {
        title: '预定管理',
        icon: 'el-icon-folder'
    },
    children: [
        {
            path: 'reserve',
            component: () => import('@/views/reserve/List'),
            name: 'ReserveList',
            meta: { title: '预定列表', icon: 'list',noCache: true }
        },
    ]
}

export default reserveRouter
