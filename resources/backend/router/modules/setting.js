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
        /*{
            path: 'setting',
            component: () => import('@/views/setting/Setting'),
            name: 'FileList',
            meta: { title: '设置', icon: 'edit',noCache: true }
        },*/

        {
            path: 'region',
            component: () => import('@/views/region/List'),
            name: 'RegionList',
            meta: { title: '地区列表', icon: 'list' }
        },
    ]
}

export default settingRouter
