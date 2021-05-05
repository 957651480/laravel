const IS_PROD = ['production', 'prod'].includes(process.env.NODE_ENV)

const plugins = ["@babel/plugin-transform-runtime"]
plugins.push([
  "import",
  {
    "libraryName": "antd",
    "libraryDirectory": "es",
    "style": "less"
  }
],)


module.exports = {
  presets: [
    '@babel/preset-react',
    [
      '@babel/preset-env',
      {
        'useBuiltIns': 'entry',
        'corejs': 3
      }
    ]
  ],
  plugins
}
