// module.exports = {
//   plugins: [
//     require('tailwindcss'),
//     require('autoprefixer'),
//     require('cssnano')({
//       preset: 'default',
//     }),
//   ],
// }

module.exports = {
    plugins: {
      tailwindcss: {},
      autoprefixer: {},
      cssnano: process.env.NODE_ENV === 'production' ? {} : false,  // Usa o cssnano somente em produção
    },
  };

// export default {
//     plugins: {
//       tailwindcss: {},
//       autoprefixer: {},
//     },
//   };

