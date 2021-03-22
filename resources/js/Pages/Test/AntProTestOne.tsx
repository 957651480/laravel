import React from 'react';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
// @ts-ignore
import Layout from '@/Pages/Layouts/Layout';


const AntProTestOne = () => {

    // @ts-ignore


    return (
        <div>
            testOne
        </div>
    );
};

AntProTestOne.layout = (page: any) => <Layout title="Users" children={page} />;

export default AntProTestOne;
