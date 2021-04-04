import React from 'react';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
// @ts-ignore
import Layout from '@/Pages/Layouts/Layout';


const List = () => {

    // @ts-ignore
    return (
        <div>
            disk
        </div>
    );
};

List.layout = (page: any) => <Layout title="Users" children={page} />;

export default List;