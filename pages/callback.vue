<template>
    <section class="container">
        <i class="fal fa-fw fa-spin fa-spinner"></i> Logging in...
    </section>
</template>

<script>
    import axios from '~/plugins/axios'
    import qs from 'qs'

    export default {
      beforeMount () {
        if (this.$route.query.error) {
          alert(this.$route.query.error_description)

          window.location.replace('/')
        }

        axios.post('/api/token?' + qs.stringify({
          code: this.$route.query.code
        }))
          .then((response) => {
            if (response.data.error) {
              alert(response.data.error_description)

              window.location.replace('/')
            }

            this.$localStorage.set('expire_time', response.data.expire_time)
            this.$localStorage.set('access_token', response.data.access_token)
            this.$localStorage.set('refresh_token', response.data.refresh_token)

            window.location.replace('/player')
          })
          .catch((error) => {
            alert(error)

            window.location.replace('/')
          })
      }
    }
</script>