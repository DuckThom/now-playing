<template>
    <section class="container">
        <player></player>
    </section>
</template>

<script>
import axios from '~/plugins/axios'
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

    if (
      this.$route.query.access_token &&
      this.$route.query.refresh_token
    ) {
      let date = new Date()
      date.setHours(date.getHours() + 1)

      this.$localStorage.set('expire_time', date)
      this.$localStorage.set('access_token', this.$route.query.access_token)
      this.$localStorage.set('refresh_token', this.$route.query.refresh_token)

      // Remove the query params from the url
      window.location.href = window.location.pathname
    }

    let accessToken = this.$localStorage.get('access_token')
    let refreshToken = this.$localStorage.get('access_token')
    let expireTime = this.$localStorage.get('expire_time')

    if (!accessToken) {
      window.location.href = '/'
    }

    window.onSpotifyWebPlaybackSDKReady = () => {
      // eslint-disable-next-line
      const player = new Spotify.Player({
        name: 'Dashboard player',
        getOAuthToken: cb => {
          if (expireTime < new Date()) {
            axios.post('/api/token', {
              accessToken: accessToken,
              refreshToken: refreshToken
            }).then(response => cb(response.data.token))
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
