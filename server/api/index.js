import { Router } from 'express'

import token from './token'
import auth from './auth'

const router = Router()

// Add USERS Routes
router.use(token)
router.use(auth)

export default router
