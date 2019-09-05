// eslint-disable-next-line import/no-extraneous-dependencies
const mix = require('laravel-mix');

mix.sass('assets/sass/main.scss', 'dist/styles/cdv.css');

mix.ts(['assets/ts/WACfix.ts'], 'dist/js/bundled.ts.js');

mix.combine('assets/js/bundle/', 'dist/js/bundled.js');

mix.combine('assets/js/admin/', 'dist/js/admin.js');

mix.js('assets/vue/app.js', 'dist/js/app.vue.webpack.js');

mix.copyDirectory('assets/images', 'dist/images');

mix.webpackConfig({
  module: {
    rules: [
      {
        test: /\.pug$/,
        oneOf: [
          {
            resourceQuery: /^\?vue/,
            use: ['pug-plain-loader'],
          },
          {
            use: ['raw-loader', 'pug-plain-loader'],
          },
        ],
      },
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
        },
      },
    ],
  },
});

if (!mix.inProduction()) {
  mix
    .webpackConfig({
      devtool: 'inline-source-map',
    })
    .sourceMaps();
}

if (mix.inProduction()) {
  mix
    .extract(['vue', 'lodash', 'axios', 'vuex']);

  mix
    .options({
      autoprefixer: {
        options: {
          grid: 'autoplace',
          flexbox: true,
        },
      },
    });
}
