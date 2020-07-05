import request from '@/utils/request'

export function fetchList(query) {
  return request({
    url: '/admin/file/list',
    method: 'get',
    params: query
  })
}

export function fetchFile(id) {
  return request({
    url: '/admin/file/detail',
    method: 'get',
    params: { id }
  })
}


export function createFile(data) {
  return request({
    url: '/admin/file/create',
    method: 'post',
    data
  })
}

export function updateFile(data) {
  return request({
    url: '/admin/file/update',
    method: 'post',
    data
  })
}
