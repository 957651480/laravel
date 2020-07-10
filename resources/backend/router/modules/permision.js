/** When your routing table is too long, you can split it into small modules**/

import Layout from '@/layout'

const permissionRouter = {
    path: '/permission',
    component: Layout,
    name: 'permission',
    meta: {
        title: '系统设置',
        icon: 'el-icon-setting'
    },
    children: [
    ]
}

export default permissionRouter
