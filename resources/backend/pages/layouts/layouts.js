import React,{ useState } from 'react';
import Form from "@backend/pages/form";
import Table from "@backend/pages/table";
import Login from "@backend/pages/auth/Login";
import {
    Link
} from "react-router-dom";
import {
    MenuUnfoldOutlined,
    MenuFoldOutlined,
    UserOutlined,
    CrownOutlined,
    VideoCameraOutlined,
    UploadOutlined,
} from '@ant-design/icons';
import ProLayout, { PageContainer } from '@ant-design/pro-layout';




function Layouts({children}){
    const [collapsed, setCollapsed] = useState(false);
    const [keyWord, setKeyWord] = useState('');
    const [pathname, setPathname] = useState('/');

    return (
        <div
            style={{
                height: '100vh',
            }}
        >
            <ProLayout
                location={{
                    pathname: pathname?pathname:'/',
                }}
                route={{
                    routes:[
                        {
                            path: '/login',
                            name: '欢迎',
                            icon: <CrownOutlined />,
                            component: Login,
                        },
                        {
                            path: '/form',
                            name: '表单',
                            icon: <UserOutlined />,
                            component: Form,
                        },
                        {
                            path: '/table',
                            name: '表格',
                            icon: <UserOutlined />,
                            component: Table,
                        },
                    ]
                }}
                collapsedButtonRender={false}
                collapsed={collapsed}
                headerContentRender={() => {
                    return (
                        <div
                            onClick={() => setCollapsed(!collapsed)}
                            style={{
                                cursor: 'pointer',
                                fontSize: '16px',
                            }}
                        >
                            {collapsed ? <MenuUnfoldOutlined /> : <MenuFoldOutlined />}
                        </div>
                    );
                }}
                menuItemRender={(item, dom) => (
                    <a href={`#${item.path}`}
                    >
                        {dom}
                    </a>
                )}
            >
                <PageContainer >
                    {children}
                </PageContainer>
            </ProLayout>
        </div>
    );
}

export default Layouts;

