const path = require('path');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

const rawArgv = process.argv.slice(2);
const report = rawArgv.includes('--report');
let plugins = [

];
plugins.push(['import', {
    'libraryName': 'ant-design-vue',
    'libraryDirectory': 'es',
    'style': true // `style: true` 会加载 less 文件
}])
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
            }
        ],
    },
    plugins: plugins,
};
