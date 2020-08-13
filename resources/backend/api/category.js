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

export function fetch(id) {
    return request({
        url: '/admin/category/detail/'+id,
        method: 'get',
        params: { id }
    })
}
export function create(data) {

    return request({
        url: '/admin/category/create',
        method: 'post',
        data
    })
}

export function update(id,data) {

    return request({
        url: '/admin/category/update/'+id,
        method: 'post',
        data
    })
}

export function destroy(id) {

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
