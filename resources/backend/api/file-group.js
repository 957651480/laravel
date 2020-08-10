import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/admin/file/group/list',
    method: 'get',
    params: query
  })
}

export function fetchFileGroup(id) {
  return request({
    url: '/admin/file/group/detail',
    method: 'get',
    params: { id }
  })
}


export function createFileGroup(data) {
  return request({
    url: '/admin/file/group/create',
    method: 'post',
    data
  })
}

export function updateFileGroup(data) {
  return request({
    url: '/admin/file/group/update',
    method: 'post',
    data
  })
}
