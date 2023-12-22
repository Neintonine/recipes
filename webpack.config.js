const MiniCssExtractPlugin = require("mini-css-extract-plugin"),
    Path = require('path'),
    fs = require('node:fs'),
    AssetsPlugin = require('assets-webpack-plugin'),
    CopyPlugin = require("copy-webpack-plugin");

const PUBLIC_FOLDER = Path.resolve(__dirname + '/public');
const SOURCE_FOLDER = Path.resolve(__dirname + '/source');
const JS_FOLDER = Path.resolve(SOURCE_FOLDER + '/js');
const PAGES_FOLDER = Path.resolve(JS_FOLDER + '/pages');
const PHP_FOLDER = Path.resolve(SOURCE_FOLDER + '/php');
const CSS_FOLDER = Path.resolve(SOURCE_FOLDER + '/scss');

function *walkSync(dir) {
    const files = fs.readdirSync(dir, { withFileTypes: true });
    for (const file of files) {
        if (file.isDirectory()) {
            yield* walkSync(path.join(dir, file.name));
        } else {
            yield path.join(dir, file.name);
        }
    }
}

for (const filePath of walkSync(PAGES_FOLDER)) {
    console.log(filePath);
}

module.exports = {
    plugins: [
        new AssetsPlugin({
            filename: 'file-index.json',
            path: PUBLIC_FOLDER,
            includeAllFileTypes: false,
            entrypoints: true,
            removeFullPathAutoPrefix: true
        }),
        new MiniCssExtractPlugin({
            filename: 'css/[name].css'
        }),
        new CopyPlugin({
            patterns: [
                {
                    from: PHP_FOLDER + '/entry/index.public.php',
                    to: PUBLIC_FOLDER + '/index.php'
                }
            ]
        })
    ],
    mode: "development",
    devtool: 'source-map',
    optimization: {
        runtimeChunk: "single",
        splitChunks: {
            cacheGroups: {
                vendor: {
                    test: /[\\/]node_modules[\\/]/,
                    name: 'vendors',
                    chunks: 'all',
                },
                common: {
                    test: /[\\/]common[\\/]/,
                    name: 'common',
                    chunks: "all"
                }
            },
        },
    },
    module: {
        rules: [
            {
                test: /\.css$/i,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader'
                ],
            },
            {
                test: /\.scss$/i,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'resolve-url-loader',
                    "sass-loader"
                ]
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf|gif|svg)$/i,
                type: 'asset/resource',
            }
        ],
    },
    resolve: {
        extensions: [".js"],
    },
    entry: {

    },
    output: {
        path: PUBLIC_FOLDER,
        filename: 'js/[name].js'
    },
}