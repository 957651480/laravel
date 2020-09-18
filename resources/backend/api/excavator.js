import request from '@/utils/request'

export function fetchList(query) {

    return request({
        url: '/admin/excavator/list',
        method: 'get',
        params: query
    })
}

export function createExcavator(data) {

    return request({
        url: '/admin/excavator/create',
        method: 'post',
        data
    })
}
export function fetchExcavator(id) {
    return request({
        url: '/admin/excavator/detail/'+id,
        method: 'get',
        params: { id }
    })
}
export function updateExcavator(id,data) {

    return request({
        url: '/admin/excavator/update/'+id,
        method: 'post',
        data
    })
}

export function deleteExcavator(id) {

    return request({
        url: '/admin/excavator/delete/'+id,
        method: 'get',
    })
}

export function batchDeleteExcavator(data) {

    return request({
        url: '/admin/excavator/batch/delete',
        method: 'post',
        data
    })
}

export function fetchCost() {

    return request({
        url: '/admin/excavator/cost',
        method: 'get',
    })
}

export function fetchExcavatorVisitList(query) {

    return request({
        url: '/admin/excavator/visit/list',
        method: 'get',
        params: query
    })
}

export function fetchExcavatorCollectList(query) {

    return request({
        url: '/admin/excavator/collect/list',
        method: 'get',
        params: query
    })
}