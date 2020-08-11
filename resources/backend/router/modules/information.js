import Layout from '@/layout'

const articleRouter= {
    path: '/article',
        component: Layout,
    redirect: '/article/list',
    name: 'Example',
    meta: {
    title: '新闻资讯管理',
        icon: 'el-icon-s-help'
    },
    children: [
        {
            path: 'create',
            component: () => import('@/views/example/create'),
            name: 'CreateArticle',
            meta: { title: '创建新闻资讯', icon: 'edit' }
        },
        {
            path: 'edit/:id(\\d+)',
            component: () => import('@/views/example/edit'),
            name: 'EditArticle',
            meta: { title: '编辑新闻资讯', noCache: true, activeMenu: '/example/list' },
            hidden: true
        },
        {
            path: 'list',
            component: () => import('@/views/example/list'),
            name: 'ArticleList',
            meta: { title: '文章列表', icon: 'list' }
        }
    ]
}

export default articleRouter;
