import request from '@/utils/request'

export function fetchList(query) {

    return request({
        url: '/admin/category/list',
        method: 'get',
        params: query
    })
}
export function fetchTopList(query) {

    return request({
        url: '/admin/category/list/top',
        method: 'get',
        params: query
    })
}

export function fetchTree(query) {

    return request({
        url: '/admin/category/tree',
        method: 'get',
        params: query
    })
}

export function fetchCategory(id) {
    return request({
        url: '/admin/category/detail/'+id,
        method: 'get',
        params: { id }
    })
}
export function createCategory(data) {

    return request({
        url: '/admin/category/create',
        method: 'post',
        data
    })
}

export function updateCategory(id,data) {

    return request({
        url: '/admin/category/update/'+id,
        method: 'post',
        data
    })
}

export function deleteCategory(id) {

    return request({
        url: '/admin/category/delete/'+id,
        method: 'get',
    })
}

export function batchDelete(data) {

    return request({
        url: '/admin/category/batch/delete',
        method: 'post',
        data
    })
}
