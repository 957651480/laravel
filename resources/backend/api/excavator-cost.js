import request from '@/utils/request'

export function fetchList(query) {

    return request({
        url: '/admin/excavator/cost/list',
        method: 'get',
        params: query
    })
}
export function fetchTopList(query) {

    return request({
        url: '/admin/excavator/cost/list/top',
        method: 'get',
        params: query
    })
}

export function fetchTree(query) {

    return request({
        url: '/admin/excavator/cost/tree',
        method: 'get',
        params: query
    })
}

export function fetchExcavatorCost(id) {
    return request({
        url: '/admin/excavator/cost/detail/'+id,
        method: 'get',
        params: { id }
    })
}
export function createExcavatorCost(data) {

    return request({
        url: '/admin/excavator/cost/create',
        method: 'post',
        data
    })
}

export function updateExcavatorCost(id,data) {

    return request({
        url: '/admin/excavator/cost/update/'+id,
        method: 'post',
        data
    })
}

export function deleteExcavatorCost(id) {

    return request({
        url: '/admin/excavator/cost/delete/'+id,
        method: 'get',
    })
}

export function batchDelete(data) {

    return request({
        url: '/admin/excavator/cost/batch/delete',
        method: 'post',
        data
    })
}
