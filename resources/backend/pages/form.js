import React from 'react';
import Layouts from "./layouts/layouts";
import ProForm, { ProFormText } from '@ant-design/pro-form';


function Form() {
    return (
        <Layouts>
            <ProForm>
                <ProFormText
                    width="md"
                    name="name"
                    label="签约客户名称"
                    tooltip="最长为 24 位"
                    placeholder="请输入名称"
                />
                <ProFormText width="md" name="company" label="我方公司名称" placeholder="请输入名称" />
            </ProForm>
        </Layouts>
    );
}

export default Form;
