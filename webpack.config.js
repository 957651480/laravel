const path = require('path');


module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
    },
    module: {
        rules: [
            {
                test: /\.less$/,
                loader: 'less-loader',
                options: {
                    javascriptEnabled: true
                }
            },
        ],
    },
};
