require('./bootstrap')

window.Vue = require('vue')

Vue.prototype.window = window

Vue.component('player', require('./components/Player.vue'))

const app = new Vue({
  el: '#app',
  data () {
    return {
      initialized: false,
      player: null
    }
  },
  created () {
    this.$root.$on('init', () => {
      this.$data.initialized = true
    })
  }
})

window.onSpotifyWebPlaybackSDKReady = () => {
  const token = window.Laravel.access_token
  const player = new Spotify.Player({
    name: 'Dashboard player',
    getOAuthToken: cb => { cb(token) }
  })

  // Bind the player to the Vue instance
  app.$data.player = player

  // Error handling
  player.addListener('initialization_error', ({ message }) => { console.error(message) })
  player.addListener('authentication_error', ({ message }) => { console.error(message) })
  player.addListener('account_error', ({ message }) => { console.error(message) })
  player.addListener('playback_error', ({ message }) => { console.error(message) })

  // Playback status updates
  player.addListener('player_state_changed', state => { app.$root.$emit('state_changed', state) })

  // Ready
  player.addListener('ready', ({ device_id }) => {
    app.$root.$emit('init')

    console.log('Ready with Device ID', device_id)
  })

  // Connect to the player!
  player.connect()
}
