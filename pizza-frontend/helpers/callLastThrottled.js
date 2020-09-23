

export const callLastThrottled = function (delayMs) {
  let lastCall = 0
  let lastCallback = null
  let timer = null

  const delayedCall = function(){
    if (timer === null) {
      timer = setTimeout(() => lastCallback(), delayMs)
    }
  }

  const clearTimer = function(){
    if (timer){
      clearTimeout(timer)
    }
  }

  const canCallImmediately = function(){
    const now = Date.now()
    const canCallImmediately = now - lastCall > delayMs
    lastCall = now
    return canCallImmediately
  }

  return function(callback){
    if (canCallImmediately()){
      clearTimer()
      return callback()
    }
    lastCallback = callback
    delayedCall()
  }
}
