import { Router } from 'express'
import { Buffer } from 'buffer'
import axios from 'axios/index'
import qs from 'qs'
import moment from 'moment'

const router = Router()
const auth = Buffer.from(process.env.CLIENT_ID + ':' + process.env.CLIENT_SECRET).toString('base64')
const headers = {
  'Authorization': 'Basic ' + auth,
  'Content-Type': 'application/x-www-form-urlencoded'
};

/* GET users listing. */
router.post('/refresh', async function (req, res) {
  try {
    const data = qs.stringify({
      grant_type: 'refresh_token',
      refresh_token: req.query.refresh_token
    })

    const response = await axios.post('https://accounts.spotify.com/api/token', data, {
      headers: headers
    })

    res.json({
      access_token: response.data.access_token,
      expire_time: moment().add(response.data.expires_in, 'seconds').format(),
    })
  } catch (e) {
    res.json(e.response.data)
  }
})

export default router
