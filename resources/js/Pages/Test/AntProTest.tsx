import React from 'react';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
// @ts-ignore
import Layout from '@/Pages/Layouts/Layout';


const Index = () => {

    // @ts-ignore
    const { users } = usePage().props;
    const {
        data,
        meta: { links }
    } = users;
    return (
        <div>
            0000
        </div>
    );
};

Index.layout = (page: any) => <Layout title="Users" children={page} />;

export default Index;
