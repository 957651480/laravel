/** When your routing table is too long, you can split it into small modules**/

import Layout from '@/layout'

const bannerRouter = {
    path: '/banner',
    component: Layout,
    redirect: '/banner/banner',
    name: 'banner',
    meta: {
        title: '轮播管理',
        icon: 'el-icon-folder'
    },
    children: [
        {
            path: 'banner',
            component: () => import('@/views/banner/List'),
            name: 'BannerList',
            meta: { title: '轮播列表', icon: 'list',noCache: true }
        },
    ]
}

export default bannerRouter
