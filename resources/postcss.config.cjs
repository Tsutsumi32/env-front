const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');

module.exports = {
  plugins: [
    autoprefixer({
      overrideBrowserslist: ['> 1%', 'last 2 versions', 'ie >= 11']
    }),
    cssnano({
      preset: 'default',
    }),
  ]
};