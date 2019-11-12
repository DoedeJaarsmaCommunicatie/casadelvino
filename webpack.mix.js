// eslint-disable-next-line import/no-extraneous-dependencies
const mix = require('laravel-mix');

mix
  .sass('assets/sass/main.scss', 'dist/styles/cdv.css')
  .ts([
    'assets/ts/WACfix.ts',
  ], 'dist/js/bundled.ts.js')
  .js('assets/js/bundle/app.client.js', 'dist/js/bundled.js')
  .js('assets/js/admin/app.admin.js', 'dist/js/admin.js')
  .js('assets/vue/app.js', 'dist/js/app.vue.webpack.js')
  .copyDirectory('assets/images', 'dist/images')
  .webpackConfig({
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
