import { Router } from 'express'
import { Buffer } from 'buffer'
import axios from 'axios'
import qs from 'qs'

const router = Router()
const foo = Buffer.from(process.env.CLIENT_ID + ':' + process.env.CLIENT_SECRET).toString('base64')
const headers = {
  'Authorization': 'Basic ' + foo,
  'Content-Type': 'application/x-www-form-urlencoded'
};

/* GET users listing. */
router.get('/', async function (req, res, next) {
  try {
    const data = qs.stringify({
      grant_type: 'authorization_code',
      code: req.params.code,
      redirect_uri: process.env.REDIRECT_URI
    })

    const response = await axios.post('https://accounts.spotify.com/api/token', data, {
      headers: headers
    })

    res.redirect('/player?' + qs.stringify(response.data))
  } catch (e) {
    res.redirect('/?' + qs.stringify(e.response.data))
  }
})

export default router
