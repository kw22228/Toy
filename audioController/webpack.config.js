const path = require("path");
const { CleanWebpackPlugin } = require("clean-webpack-plugin");
const webpack = require("webpack");

module.exports = {
  mode: "development",

  entry: "./src/index.js",

  output: {
    path: path.resolve(__dirname, "dist/"),
    filename: "audioController.bundle.js",
  },

  module: {
    rules: [
      {
        test: /\.(js)$/,
        use: {
          loader: "babel-loader",
        },
        exclude: /node_modules/,
      },
    ],
  },

  resolve: {
    extensions: [".js"],
    alias: {
      "@": path.resolve(__dirname, "src"),
      "@core": path.resolve(__dirname, "src/core"),
      "@class": path.resolve(__dirname, "src/class"),
      "@utils": path.resolve(__dirname, "src/utils"),
    },
  },

  plugins: [new CleanWebpackPlugin()],
};
