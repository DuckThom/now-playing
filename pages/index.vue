<template>
  <section class="container">
    <a class="btn btn-auth" :href="authUrl">
      Login with Spotify
    </a>
  </section>
</template>

<script>
  import axios from '~/plugins/axios'

  export default {
    async asyncData () {
      let { data } = await axios.get('/api/auth')
      return { authUrl: data }
    },
    beforeMount () {
      const accessToken = this.$localStorage.get('access_token')

      if (accessToken) {
        window.location.href = '/player'
      }
    }
  }
</script>

<style lang="scss" scoped>
  .container {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .btn {
    display: inline-block;
    padding: 15px 50px;
    border-radius: 40px;
    text-decoration: none;

    &.btn-auth {
      background-color: white;
      color: #333;

      &:hover {
        background-color: #efefef;
      }
    }
  }
</style>
