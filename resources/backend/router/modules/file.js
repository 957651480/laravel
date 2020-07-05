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
            meta: { title: '文件列表', icon: 'list',noCache: true }
        },

        {
            path: 'folder/list',
            component: () => import('@/views/file/folder/List'),
            name: 'FolderList',
            meta: { title: '文件夹列表', icon: 'list' }
        },

        {
            path: 'disk/list',
            component: () => import('@/views/file/disk/List'),
            name: 'DiskList',
            meta: { title: '磁盘列表',icon: 'list'}
        },
    ]
}

export default fileRouter
