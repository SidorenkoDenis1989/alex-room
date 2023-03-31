const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const path = require('path');
const webpack = require("webpack");

const jsPath= '/src';
const outputPath = 'dist';
const entryPoints = {
    'app': jsPath + '/index.js',
};

module.exports = {
    entry: entryPoints,
    output: {
        path: path.resolve(__dirname, outputPath),
        filename: '[name].js',
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: '[name].css',
        }),
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
        }),
    ],
    module: {
        rules: [
            {
                test: /\.(sa|sc|c)ss$/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                        options: {
                            publicPath: '',
                        }
                    },
                    {
                        loader: "css-loader",
                    },
                    {
                        loader: "sass-loader",
                    }
                ],

            },
            {
                test: /\.(jpg|jpeg|png|gif|woff|woff2|eot|ttf|svg)$/i,
                use: 'url-loader?limit=1024',
            },
        ]
    },
};