
require('./stylus/main.styl')


// Backbone.$ = $

class Poll extends Backbone.View {

  // scrolled = false

  constructor (options) {

    console.log('Quiz::constructor')

    this.firebase = new Firebase("https://senti.firebaseio.com/")

    this.setElement(options.el)
    this.$el = $(options.el)

    // Backbone view events
    this.events = {
      // 'click .cp-progress li' : 'moveToQuestion'
    };

    this.render()
    super()

  }

  render() {

  }

}

var modules = $('.js-plugin-module[data-module="Poll"]')
modules.each((index, el) => {
  new Poll({el:el})
})

