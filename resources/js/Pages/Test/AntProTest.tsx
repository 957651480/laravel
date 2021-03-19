import React, { useState } from 'react'
import ProLayout, {PageContainer,SettingDrawer} from '@ant-design/pro-layout';
import type { ProSettings } from '@ant-design/pro-layout';

export default ()=>{
    const [settings, setSetting] = useState<Partial<ProSettings> | undefined>({ fixSiderbar: true });
    return(
        <div
            id="test-pro-layout"
            style={{
                height: '100vh',
            }}
        >
            <ProLayout

                menuItemRender={
                    false
                }

            >
                <PageContainer>
                    00000
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
