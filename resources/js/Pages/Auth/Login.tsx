import React from 'react';
import { message } from 'antd';
import ProForm, { ProFormText,  } from '@ant-design/pro-form';
import { IdcardTwoTone, LockTwoTone } from '@ant-design/icons';


const waitTime = (time: number = 100) => {
    return new Promise((resolve) => {
        setTimeout(() => {
            resolve(true);
        }, time);
    });
};


const Login = () => {
    return (
        <div
            style={{
                width: 330,
                margin: 'auto',
                position: 'absolute',
                top: '30%',
                left: '50%',
                transform: 'translate(-50%, -50%)',
             }}
        >
            <ProForm
                onFinish={async () => {
                    await waitTime(2000);
                    message.success('提交成功');
                }}
                submitter={{
                    searchConfig: {
                        submitText: '登录',
                    },
                    render: (_, dom) => dom.pop(),
                    submitButtonProps: {
                        size: 'large',
                        style: {
                            width: '100%',
                        },
                    },
                }}
            >
                <h1
                    style={{
                        textAlign: 'center',
                    }}
                >
                    <img
                        style={{
                            height: '44px',
                            marginRight: 16,
                        }}
                        alt="logo"
                        src="https://gw.alipayobjects.com/zos/rmsportal/KDpgvguMpGfqaHPjicRK.svg"
                    />
                    Ant Design
                </h1>
                <div
                    style={{
                        marginTop: 12,
                        textAlign: 'center',
                        marginBottom: 40,
                    }}
                >
                    Ant Design 是西湖区最具影响力的 Web 设计规范
                </div>
                <ProFormText
                    fieldProps={{
                        size: 'large',
                        prefix: <IdcardTwoTone />,
                    }}
                    name="phone"
                    placeholder="请输入账号"
                    rules={[
                        {
                            required: true,
                            message: '请输入账号!',
                        },
                    ]}
                />
                <ProFormText.Password
                    fieldProps={{
                        size: 'large',
                        prefix: <LockTwoTone />,
                    }}
                    name="password"
                    rules={[
                        {
                            required: true,
                            message: '请输入密码',
                        },
                    ]}
                    placeholder="请输入密码"
                />
            </ProForm>
        </div>
    );
};



export default Login;
