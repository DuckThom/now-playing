<template>
    <section class="container">
        <player></player>
    </section>
</template>

<script>
import axios from '~/plugins/axios'
import moment from 'moment'
import qs from 'qs'
import Player from '~/components/Player'

export default {
  components: {
    Player
  },
  head () {
    return {
      script: [
        { src: 'https://sdk.scdn.co/spotify-player.js' }
      ]
    }
  },
  mounted () {
    this.$root.$data.player = null

    let accessToken = this.$localStorage.get('access_token')
    let refreshToken = this.$localStorage.get('refresh_token')
    let expireTime = this.$localStorage.get('expire_time')

    if (!accessToken) {
      window.location.href = '/'
    }

    window.onSpotifyWebPlaybackSDKReady = () => {
      // eslint-disable-next-line
      const player = new Spotify.Player({
        name: 'Dashboard player',
        getOAuthToken: cb => {
          if (moment(expireTime).isBefore()) {
            axios.post('/api/refresh?' + qs.stringify({
              refresh_token: refreshToken
            }))
              .then(response => {
                if (response.data.error) {
                  alert('Authentication error: ' + response.data.error_description)

                  this.$localStorage.remove('expire_time')
                  this.$localStorage.remove('access_token')
                  this.$localStorage.remove('refresh_token')

                  window.location.replace('/')
                }

                this.$localStorage.set('expire_time', response.data.expire_time)
                this.$localStorage.set('access_token', response.data.access_token)

                cb(response.data.access_token)
              })
          } else {
            cb(accessToken)
          }
        }
      })

      // Bind the player to the Vue instance
      this.$root.$data.player = player

      // Error handling
      player.addListener('initialization_error', ({ message }) => { console.error(message) })
      player.addListener('authentication_error', ({ message }) => { console.error(message) })
      player.addListener('account_error', ({ message }) => { console.error(message) })
      player.addListener('playback_error', ({ message }) => { console.error(message) })

      // Playback status updates
      player.addListener('player_state_changed', state => { this.$root.$emit('state_changed', state) })

      // Ready
      // eslint-disable-next-line
      player.addListener('ready', ({ device_id }) => {
        this.$root.$emit('init')

        console.log('Ready with Device ID', device_id)
      })

      // Connect to the player!
      player.connect()
    }
  }
}
</script>

<style lang="scss" scoped>

</style>
