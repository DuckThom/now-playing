import { Router } from 'express'

const router = Router()
const scopes = [
  'user-read-playback-state',
  'streaming',
  'user-read-birthdate',
  'user-read-email',
  'user-read-private'
]
const params = [
  'client_id=' + process.env.CLIENT_ID,
  'response_type=code',
  'redirect_uri=' + process.env.REDIRECT_URI,
  'scope=' + scopes.join(',')
]

/* GET users listing. */
router.get('/auth', function (req, res, next) {
  let url = 'https://accounts.spotify.com/authorize?' + params.join('&')

  res.json(url)
})

export default router
