import React, { useState } from 'react'
import Helmet from 'react-helmet';
import ProLayout, {PageContainer,SettingDrawer} from '@ant-design/pro-layout';
import type { ProSettings } from '@ant-design/pro-layout';
// @ts-ignore
import defaultProps from '@/Pages/route';

// @ts-ignore
//todo 暂不知道ts里带{}的参数怎么定义类型
export default function Layout({title, children}) {

    const [settings, setSetting] = useState<Partial<ProSettings> | undefined>({ fixSiderbar: true });
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
                {...defaultProps}
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
