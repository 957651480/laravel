/** When your routing table is too long, you can split it into small modules**/

import Layout from '@/layout'

const orderRouter = {
    path: '/order',
    component: Layout,
    redirect: '/order/order',
    name: 'order',
    meta: {
        title: '订单管理',
        icon: 'el-icon-folder'
    },
    children: [
        {
            path: 'order',
            component: () => import('@/views/order/List'),
            name: 'OrderList',
            meta: { title: '订单列表', icon: 'list',noCache: true }
        },
    ]
}

export default orderRouter
