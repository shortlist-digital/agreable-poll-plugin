$ = jQuery;

class AdminPoll {

  constructor (options) {

    console.log('AdminPoll::constructor')

    this.firebase = new Firebase("https://senti.firebaseio.com/")
    // console.log(this.firebase);

    this.$el = $(options.el)

    var payload = {
      'action': 'get_firebase_path',
      'post_id': parseInt(this.$el.attr('id').replace('post-', ''))
    };
    $.post(ajaxurl, payload, $.proxy(this.getRecord, this));

  }

  getRecord(path){
    this.firebase.child(path).on("value", $.proxy(this.handleValue, this));
  }

  handleValue(snapshot){
    var data = snapshot.val()
    if(data){
      this.render(data)

      var payload = {
        'action'  : 'update_poll',
        'post_id' : parseInt(this.$el.attr('id').replace('post-', '')),
        'poll'    : data
      };
      $.post(ajaxurl, payload, $.proxy(this.handleUpdatePoll, this));

    }
  }

  render(data){
    this.$el.find('.entries').html(data.entries)
  }

}

var modules = $('#the-list tr')
modules.each((index, el) => {
  new AdminPoll({el:el})
})

