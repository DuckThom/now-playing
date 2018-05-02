module.exports = {
  /*
  ** Headers of the page
  */
  head: {
    title: 'Now playing',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'Spotify on the big screen' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      { rel: 'stylesheet', crossorigin: 'anonymous', href: 'https://pro.fontawesome.com/releases/v5.0.10/css/all.css', integrity: 'sha384-KwxQKNj2D0XKEW5O/Y6haRH39PE/xry8SAoLbpbCMraqlX7kUP6KHOnrlrtvuJLR' },
      { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css?family=Gothic+A1:100,200,400,600' }
    ]
  },
  /*
  ** Global CSS
  */
  css: ['~/assets/css/main.css'],
  plugins: ['~/plugins/localstorage'],
  /*
  ** Add axios globally
  */
  build: {
    vendor: ['axios'],
    /*
    ** Run ESLINT on save
    */
    extend (config, ctx) {
      if (ctx.isClient) {
        config.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules)/
        })
      }
    }
  }
}
