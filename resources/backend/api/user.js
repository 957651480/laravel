import request from '@/utils/request'

export function login(data) {
  return request({
    url: '/admin/auth/login',
    method: 'post',
    data
  })
}

export function getInfo(token) {
  return request({
    url: '/admin/user/info',
    method: 'get',
    params: { token }
  })
}

export function logout() {
  return request({
    url: '/admin/auth/logout',
    method: 'post'
  })
}
export function fetchWeChatList(query) {
  return request({
    url: '/admin/user/wechat/list',
    method: 'get',
    params:query
  })
}