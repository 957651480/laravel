import React, { useState } from 'react'
import Helmet from 'react-helmet';
import ProLayout, {PageContainer,SettingDrawer} from '@ant-design/pro-layout';
import type { ProSettings } from '@ant-design/pro-layout';


// @ts-ignore
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

                menuItemRender={
                    false
                }

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
