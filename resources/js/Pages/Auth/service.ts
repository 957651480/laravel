import request from 'umi-request';

export interface LoginParamsType {
    userName: string;
    password: string;
}

export async function accountLogin(params: LoginParamsType) {
    return request('/admin/auth/login', {
        method: 'POST',
        data: params,
    });
}