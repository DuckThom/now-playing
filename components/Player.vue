<template>
    <div>
        <div id="player" v-if="initialized">
            <search></search>

            <album-art :image="imageSrc"></album-art>

            <track-info :song="song" :artists="artists" :album="album"></track-info>

            <controls :playing="playing"></controls>

            <playtime :time="time" :duration="duration"></playtime>

            <progress-bar :position="time" :duration="duration"></progress-bar>
        </div>

        <div v-if="initialized && showOverlay" class="overlay">
            <span>Select "Dashboard player" from your devices in Spotify</span>

            <span style="margin: 30px 0;">or</span>

            <button v-on:click="makePlayer()">Play here</button>
        </div>

        <div v-if="!initialized" class="overlay">
            <span><i class="fal fa-spin fa-spinner"></i> Loading...</span>
        </div>
    </div>
</template>

<script>
  import axios from '~/plugins/axios'
  import ProgressBar from './Player/ProgressBar'
  import TrackInfo from './Player/TrackInfo'
  import Controls from './Player/Controls'
  import Playtime from './Player/Playtime'
  import AlbumArt from './Player/AlbumArt'
  import Search from './Player/Search'

  export default {
    components: {
      AlbumArt,
      ProgressBar,
      TrackInfo,
      Controls,
      Playtime,
      Search
    },
    data () {
      return {
        deviceId: false,
        initialized: false,
        showOverlay: true,
        playing: false,
        time: 0,
        duration: 0,
        song: '',
        artists: '',
        album: '',
        imageSrc: ''
      }
    },
    methods: {
      makePlayer () {
        if (!this.$data.deviceId) {
          return
        }

        axios.put('https://api.spotify.com/v1/me/player', {
          device_ids: [ this.$data.deviceId ]
        }, {
          headers: {
            Authorization: 'Bearer ' + this.$localStorage.get('access_token')
          }
        }).catch(error => alert(error))
      }
    },
    beforeMount () {
      this.$root.$on('init', (deviceId) => {
        this.$data.deviceId = deviceId
        this.$data.initialized = true
      })

      setInterval(() => {
        if (!this.$data.playing) {
          return
        }

        let newTime = this.$data.time + 1000

        this.$data.time = (newTime > this.$data.duration ? this.$data.duration : newTime)
      }, 1000)

      this.$root.$on('state_changed', (state) => {
        console.log('State changed', state)

        if (!state) {
          // Show the overlay
          this.$data.showOverlay = true

          return
        }

        // Hide the overlay
        this.$data.showOverlay = false

        // Time
        this.$data.time = state.position
        this.$data.duration = state.duration
        this.$data.playing = !state.paused

        const currentTrack = state.track_window.current_track

        // Song
        this.$data.song = currentTrack.name
        this.$data.album = currentTrack.album.name

        let names = []
        currentTrack.artists.forEach(artist => names.push(artist.name))

        this.$data.artists = names.join(', ')

        const image = currentTrack.album.images.reduce((l, e) => e.height > l.height ? e : l)

        // Image
        this.$data.imageSrc = image.url
      })
    }
  }
</script>

<style lang="scss" scoped>
    #player {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .overlay {
        background-color: white;
        font-size: 45px;
        z-index: 1000;
        display: flex;
        color: #333;
        opacity: 1;
        justify-content: center;
        transition: opacity 1s;
        flex-direction: column;
        align-items: center;
        position: fixed;
        bottom: 0;
        right: 0;
        left: 0;
        top: 0;
    }

    button {
        display: block;
        padding: 15px 50px;
        border: 0;
        font-size: 45px;
        height: 200px;
        width: 200px;
        border-radius: 100px;
        background-color: #6AE368;
        color: #333;
        transition: all 250ms;

        &:hover {
            background-color: #efefef;
            cursor: pointer;
        }
    }
</style>