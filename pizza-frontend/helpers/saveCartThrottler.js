

import { callLastThrottled } from '~/helpers/callLastThrottled'

export const saveCartThrottler = callLastThrottled(500)
