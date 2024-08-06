const path = require('path');
const { library } = require('webpack');
const WrapperPlugin = require('wrapper-webpack-plugin');

module.exports = {
  entry: {
    'botframework-webchat': ['botframework-webchat'],
  },
  experiments: {
    outputModule: true,
  },
  mode: 'production',
  optimization: {
    minimize: false,
  },
  output: {
    filename: '[name].js',
    library: {
      //name: 'block_iagora/[name]',
      type: 'amd',
    },
    path: path.resolve(__dirname, 'amd/src'),
  },
  plugins: [
    new WrapperPlugin({
        header: '/* eslint-disable */\n/* Do not edit directly, refer to webpack.config.json. */\n\n',
        footer: ''
    }),
  ],
};
