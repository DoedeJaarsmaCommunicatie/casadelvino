// eslint-disable-next-line import/no-extraneous-dependencies
const mix = require('laravel-mix');

const purger = mix.inProduction()
  ? [
    // eslint-disable-next-line global-require
    require('@fullhuman/postcss-purgecss')({
      content: [
        './templates/**/*.html.twig',
        './assets/vue/**/*.vue',
        './assets/js/**/*.jsx',
        './assets/styles/**/*.scss',
        './assets/styles/**/*.sass',
        './templates/**/*.html',
        './templates/**/*.twig',
      ],

      defaultExtractor: (content) => content.match(/[\w-/:]+(?<!:)/g) || [],

      whitelist: ['bg-success-dark-20', 'bg-success'],
    }),
  ]
  : [];

mix
  .sass('assets/sass/main.scss', 'dist/styles/cdv.css')
  .options({
    processCssUrls: false,
    postCss: [...purger],
  })
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
    resolve: {
      alias: {
        react: 'preact/compat',
        'react-dom': 'preact/compat',
      },
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
