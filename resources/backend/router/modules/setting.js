/** When your routing table is too long, you can split it into small modules**/

import Layout from '@/layout'

const settingRouter = {
    path: '/setting',
    component: Layout,
    redirect: '/setting/setting',
    name: 'setting',
    meta: {
        title: '系统设置',
        icon: 'el-icon-setting'
    },
    children: [
        {
            path: 'setting',
            component: () => import('@/views/setting/Setting'),
            name: 'SettingList',
            meta: { title: '设置', icon: 'edit',noCache: true }
        },
    ]
}

export default settingRouter
