import React from 'react';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
// @ts-ignore
import Layout from '@/Pages/Layouts/Layout';


const Index = () => {

    // @ts-ignore


    return (
        <div>
            0000
        </div>
    );
};

Index.layout = (page: any) => <Layout title="Users" children={page} />;

export default Index;
