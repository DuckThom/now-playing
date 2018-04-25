import { Router } from 'express'

const router = Router()

/* GET users listing. */
router.get('/token', function (req, res, next) {
  res.json({
    token: 'kut'
  })
})

export default router
