import { Router } from 'express'
import { Buffer } from 'buffer'
import axios from 'axios/index'
import qs from 'qs'
import moment from 'moment'
import dotenv from 'dotenv'

dotenv.config()

const router = Router()
const auth = Buffer.from(process.env.CLIENT_ID + ':' + process.env.CLIENT_SECRET).toString('base64')
const headers = {
  'Authorization': 'Basic ' + auth,
  'Content-Type': 'application/x-www-form-urlencoded'
};

/* GET users listing. */
router.post('/token', async function (req, res) {
  try {
    const data = qs.stringify({
      grant_type: 'authorization_code',
      code: req.query.code,
      redirect_uri: process.env.REDIRECT_URI
    })

    const response = await axios.post('https://accounts.spotify.com/api/token', data, {
      headers: headers
    })

    res.json({
      access_token: response.data.access_token,
      expire_time: moment().add(response.data.expires_in, 'seconds').format(),
      refresh_token: response.data.refresh_token
    })
  } catch (e) {
    res.json(e.response.data)
  }
})

export default router
