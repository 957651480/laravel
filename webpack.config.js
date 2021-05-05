const path = require('path');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const AntdDayjsWebpackPlugin = require('antd-dayjs-webpack-plugin');


const rawArgv = process.argv.slice(2);
const report = rawArgv.includes('--report');
let plugins = [new AntdDayjsWebpackPlugin()];
if (report) {
    plugins.push(new BundleAnalyzerPlugin({
        openAnalyzer: true,
    }));
}
module.exports = {
    output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
    resolve: {
        extensions: ['.ts','.tsx','.js', '.jsx', '.json'],
        alias: {
            '@': path.resolve('resources'),
            '@backend': path.resolve('resources/backend'),
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
            }
        ],
    },
    plugins: plugins,
};
