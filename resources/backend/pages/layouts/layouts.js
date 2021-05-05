import React,{ useState } from 'react';
import Demo from "@backend/pages/demo";
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
    return (
        <div
            style={{
                height: '100vh',
            }}
        >
            <ProLayout
                location={{
                    pathname: '/',
                }}
                route={
                    [
                        {
                            path: '/login',
                            name: '欢迎',
                            icon: <CrownOutlined />,
                            component: Login,
                        },
                        {
                            path: '/demo',
                            name: '二级页面',
                            icon: <UserOutlined />,
                            component: Demo,
                        },
                    ]
                }
                collapsedButtonRender={false}
                collapsed={collapsed}
                collapsedButtonRender={false}
                /*menuDataRender={false}
                menuItemRender={false}*/
                subMenuItemRender={false}
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
            >
                <PageContainer >
                    {children}
                </PageContainer>
            </ProLayout>
        </div>
    );
}

export default Layouts;

