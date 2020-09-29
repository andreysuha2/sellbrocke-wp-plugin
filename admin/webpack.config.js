const path = require('path');
const TerserJSPlugin = require('terser-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
    entry: "./src/app.js",
    output: {
        filename: "./js/sellbroke-admin.min.js"
    },
    optimization: {
        minimizer: [new TerserJSPlugin({}), new OptimizeCSSAssetsPlugin({})]
    },
    devtool: "source-map",
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "./src/"),
            "@helpers": path.resolve(__dirname, "./src/js/helpers")
        }
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: "babel-loader"
                }
            },
            {
                test: /\.scss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    "css-loader",
                    "postcss-loader",
                    "sass-loader"
                ]
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "css/sellbroke-admin.min.css",
            chunkFilename: "[id].css"
        })
    ]
};