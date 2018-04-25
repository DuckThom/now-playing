<template>
    <div>
        <div id="player" v-if="initialized">
            <controls :playing="playing"></controls>

            <album-art :image="imageSrc"></album-art>

            <track-info :song="song" :artists="artists" :album="album"></track-info>

            <playtime :time="time" :duration="duration"></playtime>

            <progress-bar :position="time" :duration="duration"></progress-bar>
        </div>

        <div v-if="initialized && showOverlay" class="overlay">
            Select "Dashboard player" in the "Connect to a device" menu in Spotify
        </div>

        <div v-if="!initialized" class="overlay">
            <i class="fal fa-spin fa-spinner"></i> Loading...
        </div>
    </div>
</template>

<script>
    import ProgressBar from './Player/ProgressBar'
    import TrackInfo from './Player/TrackInfo'
    import Controls from './Player/Controls'
    import Playtime from './Player/Playtime'
    import AlbumArt from './Player/AlbumArt'

    export default {
      components: {
        AlbumArt,
        ProgressBar,
        TrackInfo,
        Controls,
        Playtime
      },
      data () {
        return {
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
      beforeMount () {
        this.$root.$on('init', () => {
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
        position: fixed;
        bottom: 0;
        right: 0;
        left: 0;
        top: 0;
        background-color: white;
        z-index: 1000;
        color: #333;
        font-size: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: opacity 1s;
        opacity: 1;
    }
</style>