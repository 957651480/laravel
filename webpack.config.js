const path = require('path');


module.exports = {
    output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
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
