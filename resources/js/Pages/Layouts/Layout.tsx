import React, { useState, useEffect } from 'react'
import Helmet from 'react-helmet';
import { InertiaLink } from '@inertiajs/inertia-react';
import { MenuFoldOutlined, MenuUnfoldOutlined } from '@ant-design/icons';
import type { MenuDataItem } from '@ant-design/pro-layout';
import ProLayout, {PageContainer,SettingDrawer} from '@ant-design/pro-layout';
import type { ProSettings } from '@ant-design/pro-layout';
// @ts-ignore
import route from '@/Pages/route';

// @ts-ignore
//todo 暂不知道ts里带{}的参数怎么定义类型
export default function Layout({title, children}) {

    const [settings, setSetting] = useState<Partial<ProSettings> | undefined>({ fixSiderbar: true });
    const [menuData, setMenuData] = useState<MenuDataItem[]>([]);
    const [collapsed, setCollapsed] = useState(false);
    const [loading, setLoading] = useState(true);
    const [index, setIndex] = useState(0);
    useEffect(() => {
        setMenuData([]);
        setLoading(true);
        setTimeout(() => {
            setMenuData(route);
            setLoading(false);
        }, 2000);
    }, [index]);
    return(

        <div
            id="test-pro-layout"
            style={{
                height: '100vh',
            }}
        >
            <Helmet>
                <title>Welcome {title}</title>
            </Helmet>
            <ProLayout

                title="后台管理系统"
                logo="https://gw.alipayobjects.com/mdn/rms_b5fcc5/afts/img/A*1NHAQYduQiQAAAAAAAAAAABkARQnAQ"

                menu={{
                    loading,
                }}
                location={{
                    pathname: '/',
                }}
                collapsed={collapsed}
                collapsedButtonRender={false}
                menuDataRender={() => menuData}
                menuItemRender={(item, dom) => <InertiaLink href={item.path as string}>
                    <div>{dom}</div>
                </InertiaLink>}
                subMenuItemRender={(_:any, dom:any) => <div>pre {dom}</div>}
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
                <PageContainer>
                    {children}
                </PageContainer>
            </ProLayout>
            <SettingDrawer
                pathname='/'
                getContainer={() => document.getElementById('test-pro-layout')}
                settings={settings}
                onSettingChange={(changeSetting) => setSetting(changeSetting)}
                disableUrlParams
            />
        </div>
    )
}
