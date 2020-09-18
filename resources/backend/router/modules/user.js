/** When your routing table is too long, you can split it into small modules**/

import Layout from '@/layout'

const userRouter = {
    path: '/user',
    component: Layout,
    redirect: '/user/user',
    name: 'user',
    meta: {
        title: '用户管理',
        icon: 'el-icon-folder'
    },
    children: [
        {
            path: 'user',
            component: () => import('@/views/user/List'),
            name: 'UserList',
            meta: { title: '用户列表', icon: 'list',noCache: true }
        },
    ]
}

export default userRouter
