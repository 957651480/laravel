import React,{ useState } from 'react';
import { Button, Tooltip } from 'antd';
import { DownOutlined, QuestionCircleOutlined } from '@ant-design/icons';
import type { ProColumns } from '@ant-design/pro-table';
import { Inertia } from '@inertiajs/inertia'
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import ProTable, {TableDropdown} from '@ant-design/pro-table';
import request from 'umi-request';
// @ts-ignore
import Layout from '@/Pages/Layouts/Layout';
import route from "../../route";

export type Response = {
    key: number;
    id: number;
    name: string;
};
export type ColumnDataType = {
    key: number;
    id: number;
    name: string;
    created_at: string;
    updated_at: string;
};



const columns: ProColumns<ColumnDataType>[] = [
    {
        title: 'ID',
        dataIndex: 'key',
        hideInTable:true,
        valueType: 'indexBorder',
        width: 48,
        sorter: (a, b) => a.key - b.key
    },
    {
        title: 'ID',
        dataIndex: 'id',
        width: 48,
    },
    {
        title: '名称',
        dataIndex: 'name',
        filters:true,
        sorter: true,
        width: 48,
    },
    {
        title: '创建时间',
        dataIndex: 'created_at',
        filters:true,
        sorter: true,
        valueType:'dateTime',
        width: 48,
    },
    {
        title: '更新时间',
        dataIndex: 'updated_at',
        filters:true,
        sorter: true,
        valueType:'dateTime',
        width: 48,
    },
    {
        title: '操作',
        width: 180,
        key: 'option',
        valueType: 'option',
        render: () => [
            <a key="link">编辑</a>,
            <a key="link2">删除</a>
        ],
    },
]
const List = () => {

    return (
        <ProTable<ColumnDataType>
            columns={columns}
            request={async (params) =>
                request<Response>('/admin/file/diskapi', {
                    params,
                })
            }
            rowKey="key"
            pagination={{
                showQuickJumper: true,
            }}
            dateFormatter="string"
            headerTitle="磁盘列表"
            rowSelection={{}}
            toolBarRender={() => [
                <Button type="primary" key="primary">
                    创建磁盘
                </Button>,
            ]}
        />
    );
};

List.layout = (page: any) => <Layout title="Users" children={page} />;

export default List;