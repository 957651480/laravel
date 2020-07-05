/** When your routing table is too long, you can split it into small modules**/

import Layout from '@/layout'

const fileRouter = {
    path: '/file',
    component: Layout,
    redirect: '/file/file',
    name: 'file',
    meta: {
        title: '文件管理',
        icon: 'el-icon-folder'
    },
    children: [
        {
            path: 'file/list',
            component: () => import('@/views/file/file/List'),
            name: 'FileList',
            meta: { title: '文件列表', noCache: true }
        },

    ]
}

export default fileRouter
