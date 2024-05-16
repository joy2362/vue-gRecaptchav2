// Plugins
import crud from './crud'
import helper from './helper'
import toaster from './toaster'

export function registerHelper (app) {
  app
    .use(crud)
    .use(helper)
    .use(toaster)
  }
