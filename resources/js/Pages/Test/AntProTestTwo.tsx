import React from 'react';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
// @ts-ignore
import Layout from '@/Pages/Layouts/Layout';


const AntProTestTwo = () => {

    // @ts-ignore


    return (
        <div>
            test two
        </div>
    );
};

AntProTestTwo.layout = (page: any) => <Layout title="Users" children={page} />;

export default AntProTestTwo;
