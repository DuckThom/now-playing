<template>
    <dev id="search">
        <input v-model="query" @input="search()" placeholder="Search" />

        <button @input="search()"><i class="fal fa-fw fa-search"></i></button>

        <div id="results" v-if="results">
            <div class="result" v-for="result in results" v-on:click="play(result.uri)">
                <span class="name">{{ result.name }}</span>
                <span class="artist">{{ result.artists[0].name }}</span>
            </div>
        </div>
    </dev>
</template>

<script>
    import qs from 'qs'
    import axios from '~/plugins/axios'

    export default {
      data () {
        return {
          results: []
        }
      },
      methods: {
        async play (itemId) {
          axios.put('https://api.spotify.com/v1/me/player/play', {
            uris: [ itemId ]
          }, {
            headers: {
              Authorization: 'Bearer ' + this.$localStorage.get('access_token')
            }
          }).catch(error => alert(error))

          this.query = ''
          this.$data.results = []
        },
        async search () {
          if (!this.query) {
            this.$data.results = []

            return
          }

          const data = qs.stringify({
            q: this.query,
            type: 'track'
          })

          const headers = {
            Authorization: 'Bearer ' + this.$localStorage.get('access_token')
          }

          const response = await axios.get('https://api.spotify.com/v1/search?' + data, {
            headers: headers
          }).catch(error => {
            if (error.response.data.status === 401) {
              axios.post('/api/refresh?' + qs.stringify({
                refresh_token: this.$localStorage.get('refresh_token')
              })).then(() => {
                this.search()
              }).catch(() => {
                window.location.href = '/'
              })
            }
          })

          this.$data.results = response.data.tracks.items
        }
      }
    }
</script>

<style lang="scss" scoped>
    #search {
        position: fixed;
        top: 30px;
        right: 30px;
        overflow: hidden;
        width: 370px;

        #results {
            margin-top: 10px;
            background: white;
            border-radius: 5px;
            max-height: 300px;
            overflow-y: auto;
            width: 300px;

            .result {
                color: #333;
                padding: 10px;
                border-bottom: 1px solid #efefef;
                position: relative;

                &:hover {
                    background-color: #333;
                    color: white;
                    cursor: pointer;
                }

                .name {
                    overflow: hidden;
                    font-size: 20px;
                    display: block;
                    white-space: nowrap;
                    text-overflow: ellipsis;
                }

                .artist {
                    font-size: 15px;
                    display: block;
                }
            }
        }

        button {
            background: white;
            border: 0;
            height: 50px;
            width: 50px;
            border-radius: 50px;
            outline: none;
            transition: all 25ms;

            &:hover {
                cursor: pointer;
                background: #efefef;
            }
        }

        input {
            border: 0;
            background: 0;
            border-bottom: 1px solid #bbb;
            width: 300px;
            transition: all 250ms;
            padding: 10px 0;
            margin-right: 15px;
            font-size: 20px;
            outline: none;
            color: white;
        }
    }
</style>