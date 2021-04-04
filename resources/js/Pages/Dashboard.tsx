import React from 'react';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
// @ts-ignore
import Layout from '@/Pages/Layouts/Layout';


const Dashboard = () => {

    // @ts-ignore
    return (
        <div>
            admin
        </div>
    );
};

Dashboard.layout = (page: any) => <Layout title="Users" children={page} />;

export default Dashboard;